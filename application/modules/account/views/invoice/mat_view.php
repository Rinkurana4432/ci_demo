<div class=" form-group">
   <input type="hidden" name="id" value="<?php if(!empty($invoice_detail)) echo $invoice_detail->id; ?>">
   <div class=" form-group">
      <div class=" form-group">
         <div class="panel panel-default">
            <?php
               setlocale(LC_MONETARY, 'en_IN');
               ?>
            <h3 class="Material-head">
               Ledger : <?php if(!empty($invoice_detail)){
                  $sale_ledger_name = getNameById('ledger',$invoice_detail->sale_ledger,'id');
                  echo $sale_ledger_name->name;
                  }?> </strong>
               <hr>
            </h3>
            <div class="panel-body">
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_content">
                     <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <div id="myTabContent" class="tab-content">
                           <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                 <div class="table-responsive">
                                    <table class="table table-striped">
                                       <tbody>
                                          <div class="table-responsive">
                                             <table class="table table-striped">
                                                <div class="label-box mobile-view3">
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Descriptions of <br> Goods and Services</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">HSN/SAC</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Quantity</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Rate</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Taxable Amt.</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Type</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Amount</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">After Discount</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">UOM</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Amount with Tax</div>
                                                </div>
                                                <?php
                                                   $invoice_matrial_details = json_decode($invoice_detail->descr_of_goods,true);
                                                   $subtotal_all_invoice =0;
                                                   foreach($invoice_matrial_details as $invoice_Data){ 
                                                   
                                                   	$meterial_data = getNameById('material',$invoice_Data['material_id'],'id');
                                                   ?>
                                                <div class="row-padding col-container mobile-view view-page-mobile-view" style="display: table-row;">
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;">
                                                      <label>Descriptions of <br> Goods and Services</label>
                                                      <?php echo '<span><b>'.$meterial_data->material_name.'</b><br/></span>'.substr($invoice_Data['descr_of_goods'], 0, 50);?>
                                                   </div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>HSN/SAC</label><?php echo $invoice_Data['hsnsac']; ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Quantity</label><?php echo $invoice_Data['quantity']; ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Rate</label><?php echo $invoice_Data['rate']; ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Taxable Amt.</label><?php echo $taxable_amt = $invoice_Data['quantity'] * $invoice_Data['rate']; ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Discount Type</label><?php
                                                      if($invoice_Data['disctype'] == 'disc_precnt'){
                                                      	echo 'Percentage ( '. $invoice_Data['discamt']. ' % )';
                                                       }elseif($invoice_Data['disctype'] == 'discamt'){
                                                      	echo 'Discount Value ( '. $invoice_Data['discamt'] .' )';
                                                       }else{
                                                      	 echo 'N/A';
                                                       }
                                                      	 
                                                      ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Discount Amount</label><?php 
                                                      if($invoice_Data['discamt'] != ''){ 
                                                      		if($invoice_Data['disctype'] == 'disc_precnt'){
                                                      			$basic_amt = $invoice_Data['quantity']* $invoice_Data['rate'];
                                                      			$total_amt_in_percent = $basic_amt * $invoice_Data['discamt']/100;
                                                      			echo $total_amt_in_percent;
                                                      		}else{
                                                      			echo $invoice_Data['discamt'];
                                                      		}
                                                      	} else { 
                                                      		echo 'N/A'; 
                                                      	} 
                                                      ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                                      <label>After Discount</label>
                                                      <?php 
                                                         if($invoice_Data['disctype'] !=''){
                                                         	if($invoice_Data['disctype'] == 'disc_precnt'){
                                                         	$basic_amt = $invoice_Data['quantity'] * $invoice_Data['rate'];
                                                         	$total_amt_in_percent = $basic_amt * $invoice_Data['discamt']/100;
                                                         	echo $taxable_amt - $total_amt_in_percent;
                                                         }else{
                                                         	echo $taxable_amt - $invoice_Data['discamt'];
                                                         }
                                                         }else{
                                                         	echo 'N/A';
                                                         }	
                                                         	$ww =  getNameById('uom', $invoice_Data['UOM'],'id');
                                                         	$uom = !empty($ww)?$ww->ugc_code:'';										
                                                         ?>	
                                                   </div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Tax</label><?php echo $invoice_Data['tax']; ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>UOM</label><?php echo $uom; ?></div>
                                                   <?php
                                                      $subtotal_invoice_amt = $invoice_Data['quantity'] * $invoice_Data['rate'];
                                                       $subtotal_all_invoice 	+= $subtotal_invoice_amt;
                                                      		
                                                      ?>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Amount with Tax</label><?php if($invoice_Data['disctype'] == ''){ 
                                                      //echo number_format($subtotal_invoice_amt);
                                                      //echo number_format((float)$subtotal_invoice_amt, 2, '.', '');
                                                      echo money_format('%!i',$subtotal_invoice_amt);
                                                      }else{echo  $invoice_Data['amount_with_tax_after_disco'];}?></div>
                                                </div>
                                                <?php  } ?>
                                                <div class="row-padding col-container mobile-view view-page-mobile-view" style="display: table-row;">
                                                   <?php 
                                                      $data_charges_json = json_decode($invoice_detail->charges_added,true);
                                                      // 
                                                      if($data_charges_json !=''){
                                                      	$charge_subtotal = 0;
                                                      	$charges_total_for_outside = 0;
                                                         
                                                      	foreach($data_charges_json as $charge_Data1){
                                                      		
                                                      		$charges_name = getNameById('charges_lead',$charge_Data1['particular_charges_name'],'id');
                                                      		if(!empty($charges_name)){
                                                      		$charge_subtotal = $charge_Data1['amt_with_tax'] -  $charge_Data1['charges_added'];
                                                      		$total_added_charges = $charge_Data1['charges_added'];
                                                      		if($charges_name->type_charges == 'plus'){
                                                      			$charges_total_for_outside += $total_added_charges;
                                                      			$charges_total_tax_outside += $charge_subtotal;
                                                      		}
                                                      		
                                                      		  if($charges_name->type_charges == 'plus'){
                                                      ?>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1 !important;"><?php echo $charges_name->particular_charges . ' ' .$charges_name->tax_slab.' %'; ?></div>
                                                   <?php }else{ ?>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charges_name->particular_charges; ?></div>
                                                   <?php } ?>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charges_name->hsnsac; ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group">>N/A</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php if($charges_name->tax_slab != 'Select Tax Slab'){echo $charges_name->tax_slab;}else{echo 'N/A';}; ?></div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
                                                   <div class="col-md-1 col-sm-12 col-xs-12 form-group"><b> <?php  echo money_format('%!i',$total_added_charges); ?></b></div>
                                                </div>
                                                <?php
                                                   }	
                                                   } 
                                                   }?>	
                                             </table>
                                          </div>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
                                       <div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
                                          <div class="col-md-12 col-sm-5 col-xs-12 text-right">
                                             <div class="col-md-6 col-sm-5 col-xs-6 ">
                                                Total : 
                                             </div>
                                             <div class="col-md-6 text-left">
                                                <?php 
                                                   $amount_details = json_decode($invoice_detail->invoice_total_with_tax,true);
                                                   
                                                   //echo $subtotal_invoice_amt;
                                                   if(!empty($data_charges_json)){
                                                   $charge_amount_add = $charges_total_for_outside;
                                                   }else{
                                                   	$charge_amount_add = 0;
                                                   }
                                                   //echo $charge_amount_add;
                                                   $total_add = $amount_details[0]['total'] + $charge_amount_add;
                                                   ?>
                                                <?php 
                                                   //echo $total_add;
                                                   //echo number_format((float)$total_add, 2, '.', '');
                                                   echo money_format('%!i',$total_add);
                                                   	
                                                   ?>
                                             </div>
                                             <div class="col-md-6 col-sm-5 col-xs-6 ">
                                                Tax : 
                                             </div>
                                             <div class="col-md-6 text-left">
                                                <?php
                                                   if(!empty($data_charges_json)){
                                                   	$charges_tax = $charges_total_tax_outside;
                                                   	}else{
                                                   		$charges_tax  = 0;
                                                   	}
                                                   	
                                                   	$tax_total3 = $amount_details[0]['totaltax'] + $charges_tax;
                                                   
                                                   
                                                   echo money_format('%!i',$tax_total3);
                                                   ?>
                                             </div>
                                             <?php
                                                if($amount_details[0]['cess_all_total'] != 0 || $amount_details[0]['cess_all_total'] != ''){
                                                ?>
                                             <div class="col-md-6 col-sm-5 col-xs-6 ">
                                                CESS : 
                                             </div>
                                             <div class="col-md-6 text-left">
                                                <?php 
                                                   $cess_AMT = $amount_details[0]['cess_all_total'];
                                                   
                                                   echo money_format('%!i',$cess_AMT);
                                                   ?>
                                             </div>
                                             <?php } ?>
                                             <div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
                                                <div class="col-md-6 col-sm-5 col-xs-6 form-group">
                                                   Grand Total : 
                                                </div>
                                                <div class="col-md-6 text-left form-group"><?php 
                                                   $prpr_totl = $total_add + $tax_total3 + $cess_AMT; 
                                                   echo money_format('%!i',$prpr_totl);
                                                   ?>
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
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <!-- <div class="ln_solid"></div>----->
                     <div class="form-group">
                        <div class="modal-footer">
                           <?php// if((!empty(invoice_detail) && $invoice_detail->save_status ==1)){ ?>
                           <!--a href="<?php //echo base_url(); ?>account/create_pdf/<?php //echo $invoice_detail->id; ?>" target="_blank"><button class="btn btn-default">Generate PDF</button></a>
                              <button class="btn btn-default sharevia_email_cls">Share Via Email</button-->
                           <?php //} ?>
                           <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
                           <!--button type="reset" class="btn btn-default">Reset</button>
                              <input type="submit" class="btn btn-warning" value="Submit"-->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Add Party Modal-->
<!-- Add Party Modal-->