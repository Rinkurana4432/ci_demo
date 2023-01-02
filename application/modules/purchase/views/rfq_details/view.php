<style>
.col-container {display: table-row;}
.col, .col-container .form-group{word-break: unset;}
</style>
<!-- Change Status work Start -->	
<?php 	
   $indentCode = ($indents && !empty($indents))?$indents->indent_code:'';
   $statusDetail = JSON_decode($indents->status);	
   ?>
<div class="container body">
   <div class="main_container">  
      <div class="col-md-12 col-sm-12 col-xs-12" role="main">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                  <div class="x_content">
                     <!-- Smart Wizard -->
                     <div id="wizard" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps list-top">
                           <li>
                              <a href="javascript:void(0);">
                              <span class="not_value">Purchase Indent</span>
                              <span class="step_descr"><small></small></span>
                              </a>
                           </li>
                           <li>
                              <a href="javascript:void(0);">
                              <span class="dsgn_cls">Purchase RFQ</span>
                              <span class="step_descr"><small></small></span>
                              </a>
                           </li>
                           <?php //This conditions is check po created or not 					
                              if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) &&  $statusDetail->PO->po_or_verbal != '' ||  $statusDetail->PO->po_code != '') ||  ($indents->po_or_not == 1)){
                              ?>
                           <li>
                              <a href="javascript:void(0);">
                              <span class="not_value">Purchase Order</span>
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
                              if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form != ''  ||  $statusDetail->MRN->mrn_code != '' || $statusDetail->MRN->invoice_no != '' )){
                              //	if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->name == 'MRN' || $statusDetail->MRN->mrn_or_without_form != '' && $statusDetail->MRN->mrn_code != '' ) || ($mrn != '')){
                              
                              	?>
                           <li>
                              <a href="javascript:void(0);">
                                 <!-- not_value -->
                                 <span class="not_value">GRN</span>
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
                           <?php if($indents->ifbalance == 0){ // 0 Means Complete Payment ?>
                           <li>
                              <span class="dsgn_cls  <?php if ($indents->approve ==1){ ?> slide-toggle  <?php } ?>" >Payment<i class="fa fa-chevron-circle-down"></i></span>
                              <span class="step_descr"><small></small></span>
                           </li>
                           <?php } elseif($indents->ifbalance == 1) { //1 Means Payment Not Complete ?>
                           <li>
                              <span class="not_value <?php if ($indents->approve ==1){ ?> slide-toggle  <?php } ?>">Payment<i class="fa fa-chevron-circle-down"></i></span>
                              <span class="step_descr"><small></small></span>
                           </li>
                           <?php } ?> 
                        </ul>
                        <div class="box1" style="display:none;">
                           <div class="box-inner" >
                              <!--h2 class="StepTitle">Step 3 Content</h2-->
                              <?php 
                                 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
                                 ?>
                              <div class="heading">
                                 <h4><?php  echo $indentCode; ?></h4>
                              </div>
                              <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/saveStatusPI" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
                                 <input type="hidden" name="id" value="<?php if($indents && !empty($indents)){ echo $indents->id;} ?>" >	
                                 <input type="hidden" value="Purch_indent" name="Purch_indent_Data">
                                 <input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
                                 <?php
                                    if(empty($indents)){
                                    ?>
                                 <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
                                 <?php }else{ ?>	
                                 <input type="hidden" name="created_by" value="<?php if($indents && !empty($indents)){ echo $indents->created_by;} ?>" >
                                 <?php } ?>
                                 <div class="item form-group" <?php  if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete'){ } ?>>
                                    <!-- echo 'style="pointer-events:none;"' -->
                                    <div class="container">
                                       <div class="col-lg-12">
                                          <div class="col-xs-6">Status</div>
                                          <div style=" float:right;" class="pull-right col-xs-6">
                                             <p class="pull-right"><b>Purchase Indent  ID : </b> <?php echo $indents->id; ?></p>
                                             <!--p class="pull-right"><b> PI Grand Total : </b> <?php //echo $indents->grand_total; ?></p>
                                                <p><b>Balance : </b> <?php //echo $indents->ifbalance; ?></p-->
                                          </div>
                                       </div>
                                    </div>
                                    <div class="container view-paymt">
                                       <div class="col-sm-12 col-xs-12 col-md-4">
                                          <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                             <center>PO  <input type="checkbox" name="pi_status[]" id="poCheck" value="po" <?php  if((!empty($statusDetail) && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->name == 'PO' &&  $statusDetail->PO->po_or_verbal != '' ||  $statusDetail->PO->po_code != '') || ($indents->po_or_not == 1)){ echo 'checked'; }  ?> style="pointer-events:<?php if( $indents->po_or_not == 1){ echo 'none'; } ?>"><br />
                                             </center>
                                          </div>
                                          <div class="poSection col-md-12 col-xs-12 view-bg" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) &&  $statusDetail->PO->po_or_verbal != '') || ($indents->po_or_not == 1)){ echo 'block'; }else{ echo 'none';} ?>;">
                                             <div class="col-md-12 col-sm-12 col-xs-12 border-rg">
                                                <div class="radio">
                                                   <label>
                                                   <input type="radio" class="flat" name="po_or_verbal"   value="verbal" <?php  if(!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal' || empty($po)){ echo 'checked'; }  if( $indents->po_or_not == 1){ ?>  onclick="return false" <?php } ?>> Verbal
                                                   </label>
                                                </div>
                                                <div class="radio">
                                                   <label>							
                                                   <input type="radio" class="flat po_code"  name="po_or_verbal" value="po_code" <?php  if((!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'po_code') && ($indents->po_or_not == 1) || !empty($po) ){ echo 'checked'; } ?>   <?php if( (!empty($statusDetail)  && (array_key_exists("PO",$statusDetail)) && $statusDetail->PO->po_or_verbal == 'verbal') || ($indents->po_or_not == 1)){ ?>  onclick="return false" <?php } ?>> PO Code
                                                   </label>
                                                </div>
                                                <?php
                                                   if(!empty($po)){
                                                   	echo '<h5><b>Po Generated List</b></h5>';
                                                   	$po_code = '';
                                                   	foreach($po as $poVal){
                                                   		$po_code_id .= $poVal['id'].'<br>';
                                                   		$po_code .= $poVal['order_code'].'<br>';
                                                   	}
                                                   	//echo $po_code;
                                                   	 echo '<a href="javascript:void(0)" id="'.$po_code_id.'" data-id="OrderView" class="add_purchase_tabs">'.$po_code.'</a>';
                                                   }
                                                   ?>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-12 col-xs-12 col-md-4">
                                          <div class="col-md-12 col-sm-12 col-xs-12 view-bg">
                                             <center>GRN <input type="checkbox" name="pi_status[]" id="mrnCheck" value="mrn" <?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->name == 'MRN' && $statusDetail->MRN->mrn_or_without_form != '' || $statusDetail->MRN->mrn_code != '' || $statusDetail->MRN->invoice_no != '') ){ echo 'checked'; } ?> style="pointer-events:<?php //if( $indents->mrn_or_not == 1){ echo 'none'; } ?>"><br /></center>
                                          </div>
                                          <div class="mrnSection col-md-12 col-xs-12" style="display:<?php  if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form != '' || $statusDetail->MRN->invoice_no != '') ){ echo 'block'; }else { echo 'none'; }  ?>;">
                                             <div class="col-md-12 col-sm-12 col-xs-12 border-rg">
                                                <div class="radio">
                                                   <label>							
                                                   <input type="radio" class="flat mrnwithout_form"  name="mrn_or_without_form"  value="Without Form" <?php  if(!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'Without Form'){ echo 'checked'; }   ?>> Without Form
                                                   </label>
                                                </div>
                                                <div class="radio">
                                                   <label>							
                                                   <input type="radio" class="flat mrninvoice_no"  name="mrn_or_without_form" value="mrn_code" 
                                                      <?php 
                                                         if((!empty($statusDetail)  && (array_key_exists("MRN",$statusDetail)) && $statusDetail->MRN->mrn_or_without_form == 'mrn_code')){ 
                                                         echo 'checked';
                                                         } ?>> Invoice No.
                                                   </label>
                                                   <br/>
                                                </div>
                                                <?php
                                                   if(!empty($mrn)){
                                                   	
                                                   	echo '<h5><b>GRN Invoice No.</b></h5>';
                                                   	$invoice_no = '';
                                                   	foreach($mrn as $mrnVal){
                                                   		$invoice_no .= $mrnVal['bill_no'].'<br>';
                                                   	}
                                                   	echo $invoice_no;
                                                   }else{ 
                                                   //pre($statusDetail);
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
                                             <center>Payment <input type="checkbox" name="pi_status[]" id="paymentCheck" value="payment" <?php  if((!empty($statusDetail)  && (array_key_exists("Payment",$statusDetail)) && $statusDetail->Payment[0]->name == 'Payment') || ($indents->pay_or_not == 1)){ echo 'checked'; } ?>><br />
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
                                             <div scope="row" contenteditable = 'true' >
                                                <label class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount<span class="required">*</span></label>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                   <input type="text"  id="amount" name="edit_amount[]" class="form-control" placeholder="amount" value="<?php echo $paymentData->amount; ?>" required="required" onkeypress="return float_validation(event, this.value)" <?php if($statusDetail->Complete->name == 'Complete'){echo 'disabled';} ?> >
                                                </div>
                                             </div>
                                             <!--td ><?php// echo $paymentData->balance; ?></td-->
                                             <div>
                                                <label class="col-md-12 col-sm-12 col-xs-12" for="req_date">Date<span class="required">*</span></label>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                   <input type="text" id="req_date1" name="edit_required_date[]" class="form-control" placeholder="Date" value="<?php echo $paymentData->required_date; ?>" required="required" <?php if($statusDetail->Complete->name == 'Complete'){echo 'disabled';} ?>>
                                                </div>
                                             </div>
                                             <div>
                                                <label class="col-md-12 col-sm-12 col-xs-12" for="specification">Narration</label>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                   <textarea  id="description" name="edit_description[]" class="form-control" placeholder="description" <?php if($statusDetail->Complete->name == 'Complete'){echo 'disabled';} ?>><?php echo $paymentData->description; ?></textarea>
                                                </div>
                                             </div>
                                             <?php	} echo '</tbody>
                                                </table>';
                                                ?>
                                             <input type="hidden" name="check_payment_complete" id="check_payment_complete" value="<?php if($indents->ifbalance == 0){ echo 'complete_payment';} ?>">
                                             <?php }	
                                                if( $indents->ifbalance !=0 ){
                                                ?>
                                             <div <?php  if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete' && $indents->pay_or_not = 1){ echo 'style="display:none;"'; } ?>  >
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
                                                      <input type="text" id="req_date12" name="required_date" class="form-control" placeholder="Date" value=""  style="width:90%;" >
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
                                       <!--<div class="col-sm-12 col-xs-12"><div class="view-bg bottam-check" >Complete <input type="checkbox" name="pi_status[]" id="completeCheck" value="complete" </?php  if((!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete') || (($indents->po_or_not == 1) && ($indents->mrn_or_not == 1) && ($indents->pay_or_not == 1))){ echo 'checked'; } elseif($indents->ifbalance == 0){echo 'enabled';}else{ echo 'disabled';} ?> >	<br /></div></div>-->
                                       <div class="col-sm-12 col-xs-12">
                                          <div class="view-bg bottam-check" >Complete<input type="checkbox" name="pi_status[]" id="completeCheck" value="complete" <?php  if((!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete') || (($indents->po_or_not == 1) && ($indents->mrn_or_not == 1) && ($indents->pay_or_not == 1))){ echo 'checked'; } elseif($indents->ifbalance == 0){echo 'enabled';}else{ echo 'disabled';} ?> >	<br /></div>
                                       </div>
                                    </div>
                                 </div>
                                 <input type="hidden" value="<?php echo $indents->ifbalance; ?>" name="indent_grand_totl" id="get_balance">
                                 <input type="hidden" value="<?php echo $indents->grand_total; ?>" name="grand_total" >
                                 <!--div class="form-group" <?php  //if(!empty($statusDetail)  && (array_key_exists("Complete",$statusDetail)) && $statusDetail->Complete->name == 'Complete'){ 	echo 'style="display:none;"'; } ?>--> 
                                 <div class="form-group" <?php if($statusDetail->Complete->name == 'Complete'){echo 'style="display:none;"';} ?>>
                                    <div class="form-group">
                                       <div class="col-md-12 col-xs-12">
                                          <center>
                                             <a class="btn  btn-default" onclick="location.href='<?php echo base_url();?>purchase/purchase_indent'">Close</a>
                                             <button type="reset" class="btn edit-end-btn ">Reset</button>
                                             <?php if((!empty($indents) && $indents->save_status !=1) || empty($indents)){
                                                echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
                                                }?> 
                                             <input type="submit" value="Send Email" class="btn edit-end-btn">
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
<!-- Change Status work Start -->
<!-- Change Status work Start -->
<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv" style="padding:0px;">
   <h3 class="Material-head">
      Indent details
      <hr>
   </h3>
   <div class=" col-md-6 col-xs-12 col-sm-6 label-left   " style="overflow:auto; padding:0px;">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">For Company Unit:<span class="required">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div><b>
                  <?php if(!empty($indents)){
                     $brnch_name = getNameById('company_address',$indents->company_unit,'compny_branch_id');
                      echo $brnch_name->company_unit;
                     } ?>
                  </b>
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Inductor:</label>   
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div >
                  <?php if(!empty($indents)){ echo $indents->inductor; } ?>                              
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Indent Number :</label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div >
                  <?php echo $indents->indent_code; ?>                           
               </div>
            </div>
         </div>
         <!-- <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Preferred Supplier</label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div >
                  <?php if(!empty($suppliername)){                                  
                     $indents->preffered_supplier;                                   
                     $supplierName=getNameById('supplier',$indents->preffered_supplier,'id');                     
                                     
                     ?>                      
                  <?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
                  <?php }?>                        
               </div>
            </div>
         </div> -->
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Delivery Address:<span class="required">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div><b>
                  <?php if(!empty($indents)){
                     $brnch_name = getNameById_with_cid('company_address', $indents->delivery_address, 'id','created_by_cid',$this->companyGroupId);
                      echo $brnch_name->location;
                     } ?>
                  </b>
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Validate By</label>                      
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div >
                  <?php 
                     // pre($indents);
                       if(!empty($indents)){                                  
                                                  
                         $username = getNameById('user_detail',$indents->validated_by,'u_id');                     
                        echo $username->name??'N/A';
                       }
                        ?>                            
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-xs-12 col-sm-6 label-left " style=" padding:0px;">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Required Date:<span class="required">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div ><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->required_date)); } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Created Date:</label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div ><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->created_date)); } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label >Department:</label>   
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div >
                  <?php if(!empty($indents)){ 
                     echo getNameById('department',$indents->departments,'id')->name??'N/A';
                     } ?>                             
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Others:</label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div>
                  <?= $indents->other??''; ?>                           
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Specification:</label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div ><?= $indents->specification??''; ?>                      
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Type:</label>
            <div class="col-md-7 col-sm-12 col-xs-6">
               <div ><?php 
                  switch ($indents->purchase_type) {
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
   <h3 class="Material-head" style="margin-bottom: 30px;">
      RFQ Details
      <hr>
   </h3>
  <div class="item form-group">
      <div class=" input_holder middle-box col-md-12" >
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Supplier Name</th>
                  <th>GSTIN</th>
                  <th>Contact person</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Delivery Date</th>
               </tr>
            </thead>
            <tbody id="table_data1">

               <?php 
               $MinAmtSupplierName = [];
               $supplierNameMinAmt = [];
               if(!empty($indents->rfq_supp)){
                  $rfq_supp_ids = json_decode($indents->rfq_supp, true);	
                  
                  for($i=0;$i<count($rfq_supp_ids);$i++){
                    $supplier = getNameById('supplier', $rfq_supp_ids[$i],'id'); 
                    
                    $supplierContactDetail =json_decode($supplier->contact_detail);
                  $GetRFQSupplier = GetRFQSupplier('purchase_rfq',$indents->id,$supplier->id);
                    if( $supplier->id == $GetRFQSupplier->supplier_id ){
                     if( $GetRFQSupplier->supplier_expected_amount != 0 && !empty($GetRFQSupplier->supplier_expected_amount) ){
                        $MinAmtSupplierName[$GetRFQSupplier->supplier_expected_amount] = $supplier->name;
                     }
                    }
                    echo '<tr class="parent"  style="background-color:#ffe7db" title="Click to expand/collapse"  id="row_'.$supplier->id.'" style="cursor: pointer;">
                     <td class="details-control"><i class="fa fa-plus fa-clickable"></i></td>
                  <td>'.$supplier->name.'</td>
                  <td>'.$supplier->gstin.'</td>	
                  <td>'.$supplierContactDetail[0]->contact_detail.'</td>	
                  <td>'.$supplierContactDetail[0]->email.'</td>							
                  <td>'.$supplier->address.'</td>
                  <td>'.$GetRFQSupplier->supplier_expected_deliv_date.'</td>
                  <input type="hidden" name="supplier_details['.$supplier->id.']" value="" id="supplier_details_'.$supplier->id.'">
                    </tr>';
                     echo '<tr id="ProTable_'.$supplier->id.'" class="child-row_'.$supplier->id.'"  >
                  <td colspan="6">
                  <table class="table table-bordered" style="padding-left:50px;">
                  	<thead>
                  	   <tr>
                  <th></th>
                  		  <th>Material Type</th>
                  		  <th>Material Name</th>
                  		  <th>Description</th>
                  		  <th>Quantity</th>
                  		  <th>UOM</th>
                  		  <th>Expected Amount</th> 
                  	   </tr>
                  	</thead>
                  	<tbody>';
                   if(!empty($indents) && $indents->material_name !=''){ 
                  		$product_info = json_decode($indents->material_name);
                  		if(!empty($product_info)){
                  			foreach($product_info as $productInfo){
                  				$material_id = $productInfo->material_name_id;
                  				$materialName = getNameById('material',$material_id,'id');
                  				$ww =  getNameById('uom', $productInfo->uom,'id');
                  				$uom = !empty($ww)?$ww->ugc_code:'';
                  				$ExpectedAmount = GetExpectedPriceOFSupplier('purchase_rfq',$indents->id,$supplier->id,$material_id);


                  if(!empty($ExpectedAmount->supplier_expected_amount)){
                     $arrayOfPrices[$material_id][] = $ExpectedAmount->supplier_expected_amount;
                     $min_price = min($arrayOfPrices[$material_id]);
                     //$checked = ($min_price == $ExpectedAmount->supplier_expected_amount) ? 'checked' : '';
                     $setchecked = "";
                     if($ExpectedAmount->selected_status == 1){	
                        $Matarray[] =  $ExpectedAmount->product_id;
                        $setchecked =  'checked';
                     }
                     if(in_array($ExpectedAmount->product_id,$Matarray)){
                        $checked  = '';
                     }
				        $mat_type_id = getNameById('material_type',$productInfo->material_type_id,'id'); 
				        if (!empty($mat_type_id)) { $mattype_name = $mat_type_id->name;	}else{ $mattype_name =  $matriealtype_name; }
                        echo '<tr>
                        <td><input disabled type="radio" class="pro_id" name="pro_id_'.$material_id.'" value="'.$supplier->id.'_'.$material_id.'_'.$ExpectedAmount->supplier_expected_amount.'_'.$ExpectedAmount->id.'" '.(!empty($setchecked)?$setchecked:$checked).'></td>
            						<td>'.$mattype_name.'</td>
            						<td>'.$materialName->material_name.'</td>
            						<td>'.$productInfo->description.'</td>	
            						<td>'.$productInfo->quantity.'</td>	
            						<td>'.$uom.'</td>
            						<td>'.$ExpectedAmount->supplier_expected_amount.'</td>							
                  					</tr>';
                  }
                  			 }									 
                  		}
                  	 }
                  	echo '</tbody> 
                    </table></td></tr>';
                              } 
                  } ?>
            </tbody>
         </table>
      </div>
     <!--  <div class="col-md-12">
         <center>
            <input type="button" value="Finalize Quotation" class="btn edit-end-btn select_price_rfq">
         </center>
      </div> -->
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="container mt-3">
      <h3 class="Material-head">
         Material Remaining Quantity
         <hr>
      </h3>
      <div class="well pro-details for-leptop-1" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px; margin-bottom:0px;">
         <?php 
            if(($indents->material_name != '') && ($indents->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]')) {  ?>
         <div class="col-container mobile-view2">
            <div class="col-md-1 col-sm-12 col-xs-12 form-group">Material Type</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Material Name</div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group">Alias</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Quantity</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Purpose</div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group">Preferred Supplier</div>
            <div class="col-md-1 col-sm-12 col-xs-12 form-group">Last Purchase Price</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Per Piece Price</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">Total Amount</div>
         </div>
         <?php 
		
            if(!empty($indents) && $indents->material_name !='' && $indents->material_name != '[{"material_type_id":"","material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]'){					
            	$materialDetail =  json_decode($indents->material_name); 
            	$Total=0;									
            	foreach($materialDetail as $material_detail){
            	$material_id=$material_detail->material_name_id;
            	$materialName=getNameById('material',$material_id,'id');
				
				$quantity =0;
				$quantity =  $material_detail->remaning_qty;
				$minprice = GetMinExpectedPrice('purchase_rfq',$indents->id,$material_detail->material_name_id);
				$sub_total = $minprice*$quantity;
				$Total+=$sub_total;	
				$PrefferedSupplier = GetPrefferedSupplier('purchase_rfq',$indents->id,$material_detail->material_name_id);

				
				 $material_type_id1 = getNameById('material_type',$material_detail->material_type_id,'id');

            	?>
         <div class="row-padding col-container mobile-view view-page-mobile-view">
		    <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
               <label>Material Type</label>
               <div><?php if (!empty($material_type_id1)) {	echo $material_type_id1->name;	} ?></div>
            </div> 
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Material Name</label>
               <div><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></h5>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
            </div>
			<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
               <label>Alias</label>
               <div><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></h5>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Quantity</label>
               <div ><?php echo $quantity;?></div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Purpose</label>								
               <div ><?php echo $material_detail->purpose;?></div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Preffered Supplier</label>
               <div>
                  <?php 
                     /*if(!empty( $MinAmtSupplierName )){
                        $MinVal = min(array_keys($MinAmtSupplierName));
                        echo $MinAmtSupplierName[$MinVal];
                     }*/
                  
                     echo getNameById('supplier',$PrefferedSupplier->supplier_id,'id')->name??'N/A';                     
                  ?>                      
               </div>
            </div>
			<div class="col-md-1 col-sm-12 col-xs-12 form-group col">
               <label>Last Purchase Price</label>
               <div>sdfgvs</div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
			
               <label>Per Piece Price</label>								
               <div ><?php echo number_format($minprice);?></div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col" style="border-right:1px solid #c1c1c1 ;">
               <label>Total Amount</label>								
               <div ><?php echo $sub_total;?></div>
            </div>
         </div>
			<?php } } }?>
      </div>
	      <table class="well pro-details for-print" id="chkIndex_1" >
         <?php 
            if(($indents->material_name != '') && ($indents->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]')) {  ?>
          <tr>
            <th>Material Name ss</th>
            <th>Alias</th>
            <th>Quantity</th>
            <th>Purpose</th>
            <th>Preffered Supplier</th>
            <th>Last Purchase Price</th>
			
            <th>Per Piece Price</th>
            <th>Total Amount</th>
         </tr>
         <?php 
            if(!empty($indents) && $indents->material_name !='' && $indents->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]'){					
            	$materialDetail =  json_decode($indents->material_name); 
            	$Total=0;									
            	foreach($materialDetail as $material_detail){
            	$material_id=$material_detail->material_name_id;
            	$materialName=getNameById('material',$material_id,'id');
   				$quantity =0;
   				$quantity =  $material_detail->remaning_qty;
   				$minprice = GetMinExpectedPrice('purchase_rfq',$indents->id,$material_detail->material_name_id);
   				$PrefferedSupplier = GetPrefferedSupplier('purchase_rfq',$indents->id,$material_detail->material_name_id);
   				$sub_total = $minprice*$quantity;
   				$Total+=$sub_total;	
	
            	 
            	
            	?>
         <tbody>
            <tr>
               <td>
               <!-- <label>Material Name</label> -->
               <div><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></h5>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
             </td>
			 <td>
               <!-- <label>Material Name</label> -->
               <div>dvf</div>
             </td>
            <td >
               <!-- <label>Quantity</label> -->
               <div ><?php echo $quantity;?></div>
            </td >
            <td>
               <!-- <label>Purpose</label> -->								
               <div ><?php echo $material_detail->purpose;?></div>
            </td >
            <td>
               <!-- <label>Preffered Supplier</label> -->
               <div>
                  <?php if(!empty($PrefferedSupplier)){                                  
                     $supplierName=getNameById('supplier',$PrefferedSupplier->supplier_id,'id');                     
                     ?>                      
                  <?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
                  <?php }?>								
               </div>
            </td>
			<td>
               <!-- <label>Material Name</label> -->
               <div>dvf</div>
             </td>
            <td>
               <!-- <label>Per Piece Price</label>								 -->
               <div ><?php echo number_format($minprice);?> sss</div>
            </td>
            <td>
               <div ><?php echo $sub_total;?></div>
            </td>
         </tr>
         <?php }                                     
            }?>
      </table>
      <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
         <div class="col-md-8 col-sm-5 col-xs-12" style="float:left;">
            <h6><b>Document</b></h6>
            <div class="x_content">
               <div class="row">
                  <div class="col-md-6">									
                     <?php
                        if(!empty($docss)){
                        $img = "";										
                        	   $imageExist = ['jpg','gif','jpeg','png','ico','jfif'];
                              $docsExist  = ['ods','doc','docx'];
                              foreach($docss as $proofs){   
                               $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
                              if(in_array($ext,$imageExist)){
                                 $img = "assets/modules/purchase/uploads/{$proofs['file_name']}";
                              }else if(in_array($ext,$docsExist)){
                                 $img = "assets/images/docX.png";
                              }else if($ext == 'pdf'){
                                 $img = "assets/images/PDF.png";
                              }else if($ext == 'xlsx'){
                                 $img = "assets/images/excel.png";   
                              }
                              if( $img )
                              echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().$img.'" alt="image" height="100" width="100"/><i class="fa fa-download"></i></a>
                                 </div></div>';
                              }
                        }else{
                        echo 'There Are No Document';
                        	
                        } 
                        
                        ?>							
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
            <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 22px;color: #2C3A61; border-bottom: 1px solid #2C3A61;">
               <div class="col-md-5 col-sm-5 col-xs-6 text-right">
                  <input type="hidden" class="form-control has-feedback-left divSubTotal" name="total" id="total" value="0">
                  Total:
               </div>
               <div class="col-md-7 col-sm-5 col-xs-6 text-left">
                  <span class="divSubTotal fa fa-rupee" aria-hidden="true"><?php if(!empty($indents)){ echo number_format($sub_total); } ?></span>
               </div>
            </div>
         </div>
      </div>
      <?php } ?>					
      <div class="col-md-12 col-xs-12">
         <center>
            <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
         </center>
      </div>
   </div>
</div>