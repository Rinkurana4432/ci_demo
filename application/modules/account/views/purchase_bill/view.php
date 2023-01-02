<input type="hidden" name="id" value="<?php if(!empty($purchase_data)){ echo $purchase_data->id;} ?>">
<div class="col-md-12 col-sm-12 col-xs-12">
   <div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label scope="row">Supplier Name</label>
         <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php
            setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
            //
              if(!empty($purchase_data)){
                 $name = getNameById('ledger',$purchase_data->supplier_name ,'id');
            	 echo $name->name;
              }
              $imageUploads = $this->account_model->get_image_byId('attachments', 'rel_id', $purchase_data->id,'purchase bill');

            ?></div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label scope="row">Supplier Address:</label>
         <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($purchase_data)){ echo $purchase_data->supp_address; } ?></div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label scope="row">Invoice Number :</label>
         <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($purchase_data)){
            echo $purchase_data->invoice_num; } ?></div>
      </div>
   </div>
   <div class="col-md-6 col-sm-6 col-xs-12 form-group label-left">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label scope="row">Bill Date :</label>
         <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($purchase_data)){
            $newDate = date("j F , Y", strtotime($purchase_data->date));
            echo $newDate; } ?></div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label scope="row">Party Email :</label>
         <div class="col-md-7 col-sm-12 col-xs-6 form-group"><?php if(!empty($purchase_data)){
            echo $purchase_data->p_email; } ?></div>
      </div>
   </div>
   <div class="label-box mobile-view3">
      <div class="col-md-2 col-sm-12 col-xs-12 form-group label" style="border-left: 1px solid #c1c1c1;">Product Details</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Description</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Unit of Measurement</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Quantity</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Rate</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Taxable Amt.</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Type</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Discount Amount</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">After Discount</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Tax %</div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group label">Amt with Tax</div>
   </div>
   <?php
      if(!empty($purchase_data)){
      	$bill_detail = json_decode($purchase_data->descr_of_bills);
      		foreach($bill_detail as $bill_details){
      			//pre($bill_details);

      ?>
   <div class="row-padding col-container mobile-view view-page-mobile-view mailing-box">
      <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;">
         <label>Product Details</label>
         <div><?php
            $name = getNameById('material',$bill_details->product_details,'id');
            echo $name->material_name;


            ?></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Description</label>
         <div><?php  echo $bill_details->descr_of_bills;  ?><br /></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Unit of Measurement</label>
         <div><?php
            $ww =  getNameById('uom', $bill_details->UOM,'id');
            						$uom = !empty($ww)?$ww->ugc_code:'';

            						echo $uom; ?><br /></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Quantity</label>
         <div><?php  echo $bill_details->qty;  ?><br /></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Rate</label>
         <div><?php  echo money_format('%!i',$bill_details->rate);//echo $bill_details->rate;  ?><br /></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Taxable Amt.</label>
         <div><?php
            $taxable_amt = $bill_details->qty * $bill_details->rate;
            //echo $taxable_amt;
            echo money_format('%!i',$taxable_amt);
            ?><br /></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Discount Type</label>
         <div><?php
            if($bill_details->disctype !=''){
            	if($bill_details->disctype == 'disc_precnt'){
            		echo 'Percentage ( '. $bill_details->discamt. ' % )';
            	}else{
            		echo 'Discount Value ( '. $bill_details->discamt .' )';
            		}
            	}else{ echo 'N/A';}
            ?></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Discount Amount</label>
         <div><?php
            if($bill_details->discamt != ''){
            	if($bill_details->disctype == 'disc_precnt'){
            		$basic_amt = $bill_details->qty * $bill_details->rate;
            		$total_amt_in_percent = $basic_amt * $bill_details->discamt/100;
            		//echo $total_amt_in_percent;
            		echo money_format('%!i',$total_amt_in_percent);
            	}else{
            		//echo $bill_details->discamt;
            		echo money_format('%!i',$bill_details->discamt);
            	}
            } else {
            	echo 'N/A';
            }
            ?></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>After Discount</label>
         <div><?php
            if($bill_details->disctype !=''){
            	if($bill_details->disctype == 'disc_precnt'){
            	$basic_amt = $bill_details->qty * $bill_details->rate;
            	$total_amt_in_percent = $basic_amt * $bill_details->discamt/100;
            	//echo $taxable_amt - $total_amt_in_percent;
            	$Tax_able_amt =  $taxable_amt - $total_amt_in_percent;
            	echo money_format('%!i',$Tax_able_amt);
            }else{
            	//echo $taxable_amt - $bill_details->discamt;
            	$Tax_able_amt =  $taxable_amt - $bill_details->discamt;
            	echo money_format('%!i',$Tax_able_amt);
            }
            }else{
            	echo 'N/A';
            }
            ?></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Tax %</label>
         <div><?php if($bill_details->tax == ''){echo 'N/A';}else{ echo $bill_details->tax; } ?><br /></div>
      </div>
      <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <label>Amt with Tax</label>
         <div><?php echo money_format('%!i',$bill_details->amountwittax);?><br /></div>
      </div>
   </div>
   <?php }
      $data_charges_json = json_decode($purchase_data->charges_added,true);

      	if($data_charges_json[0]['particular_charges_name'] !=''){
      		$charge_subtotal = 0;
      		$charges_total_for_outside = 0;
      		$charges_total_tax_outside = 0;
      		$charge_Discount = 0;

      		foreach($data_charges_json as $charge_Data1){


      ?>
   <div class="row-padding col-container mobile-view view-page-mobile-view">
   <?php
      $charges_name = getNameById('charges_lead',$charge_Data1['particular_charges_name'],'id');

       if(!empty($charges_name)){
      $charge_subtotal = $charge_Data1['amt_with_tax'] -  $charge_Data1['charges_added'];
      $total_added_charges = $charge_Data1['charges_added'];
      if($charges_name->type_charges == 'plus'){
      	$charges_total_for_outside += $total_added_charges;
      	$charges_total_tax_outside += $charge_subtotal;
      	$total_chargesWithTax += $charge_Data1['amt_with_tax'];
      }
      if($charges_name->type_charges == 'minus'){
      	$total_added_discount_charges = $charge_Data1['charges_added'];
      	$charge_Discount += $total_added_discount_charges;
      }

        if($charges_name->type_charges == 'plus'){
      ?>
      <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><?php echo $charges_name->particular_charges . ' ' .$charges_name->tax_slab.' %'; ?>
      </div>
      <?php }else{ ?>

         <div class="col-md-1 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><?php echo $charges_name->particular_charges; ?>
         </div>
         <?php } ?>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charges_name->hsnsac; ?>
         </div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charge_Data1['charges_added'];?></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><?php echo $charge_Data1['charges_added'];?></div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group">N/A</div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group">
            <b>
            <?php
               if($charges_name->tax_slab != 'Select Tax Slab' && $charges_name->type_charges != 'minus')
               	{
               	echo $charges_name->tax_slab;
               	}else{
               		echo 'N/A';
               		} ?>
            </b>
         </div>
         <div class="col-md-1 col-sm-12 col-xs-12 form-group"><b>
            <?php
               if( $charge_Data1['type_charges'] == 'minus'){
               	echo money_format('%!i',$charge_Data1['charges_added']);
               }else{
               	echo money_format('%!i',$charge_Data1['amt_with_tax']);
               }
               ?>
            </b>
         </div>
   </div>
<?php } ?>
</div>
<?php } } 	
   } ?>
   <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
      <div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
         <div class="col-md-12 col-sm-5 col-xs-12 text-right">
            <div class="col-md-6 col-sm-5 col-xs-6 ">Total : </div>
            <div class="col-md-6 text-left">
               <?php
                  $amount_details = json_decode($purchase_data->invoice_total_with_tax,true);
                  		echo money_format('%!i',$amount_details[0]['total']);
                ?>
            </div>
            <div class="col-md-6 col-sm-5 col-xs-6 ">Tax : </div>
            <div class="col-md-6 text-left">
               <?php
                  $tax_total3 = $amount_details[0]['totaltax']; //+ $charges_total_tax_outside;
                  	echo money_format('%!i',$tax_total3);
                  ?>
            </div>
            <?php
            	$addCharge = 0;
            	if($purchase_data->charges_added){
            		$data_charges_json = json_decode($purchase_data->charges_added,true);
	            	if( $data_charges_json ){
	            		foreach($data_charges_json as $charge_Data1){
	            			$charges_name = getNameById('charges_lead',$charge_Data1['particular_charges_name'],'id');
	            		?>
	            		<div class="col-md-6 col-sm-5 col-xs-6 "><?=  $charges_name->particular_charges ?> : </div>
			            <div class="col-md-6 text-left">
			               <?php

                              if( $charge_Data1['type_charges'] == 'plus' ){
			               		 $addCharge += $charge_Data1['amt_with_tax'];
                              }else{
                                 $discount = $charge_Data1['amt_with_tax'];
                              }
                              echo $charge_Data1['amt_with_tax'];


			                ?>
			            </div>
	            		<?php
                     }
	            		}
	            	}
              ?>


            <?php
               if($amount_details[0]['cess_all_total'] != 0){
               ?>
            <div class="col-md-6 col-sm-5 col-xs-6 ">CESS : </div>
            <div class="col-md-6 text-left">
               <?php
                  $tax_totalcess = $amount_details[0]['cess_all_total'];
                  echo money_format('%!i',$tax_totalcess);
                  ?>
            </div>
            <?php }
               if($amount_details[0]['tcsonOffAMT'] != 0){

               ?>
            <div class="col-md-6 col-sm-5 col-xs-6 ">TCS : </div>
            <div class="col-md-6 text-left">
               <?php
                  // $tax_totalcess = $amount_details[0]['tcsonOffAMT'];
                   echo $amount_details[0]['tcsonOffAMT'];
                  ?>
            </div>
            <?php }
               $decimal = strrchr($purchase_data->total_amount,".");
               if($decimal != 0){
               ?>
            <div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
               <div class="col-md-6 col-sm-5 col-xs-6 form-group">Round Off : </div>
               <div class="col-md-6 text-left form-group">
                  <?php
                     $roundoff =  $purchase_data->grand_total - $purchase_data->total_amount;
                     echo floor($roundoff*100)/100;
                     ?>
               </div>
            </div>
            <?php
               }
               ?>


            <div class="col-md-12 col-sm-12 col-xs-12 text-right grand-tota2">
               <div class="col-md-6 col-sm-5 col-xs-6 form-group">Grand Total : </div>
               <div class="col-md-6 text-left form-group">
                  <?php



                     if($charge_Discount == 0){
                     	$tttt = $amount_details[0]['total'] + $tax_total3 + $tax_totalcess;
                     	echo money_format('%!i',$tttt);
                     }else{
                     $ddt = $after_discount + $amount_details[0]['total'] + $tax_total3 + $tax_totalcess + $addCharge;
                     $ddt = (int)$ddt;
                     echo money_format('%!i',$ddt);
                     }
                     // echo money_format('%!i',$purchase_data->grand_total);

                     ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-8 col-sm-12 col-xs-12 label-left">
      <label>Message</label>
      <div class="col-md-6"><?php if(!empty($purchase_data)) echo $purchase_data->message_for_email; ?></div>
   </div>
   <div class="col-md-8 col-sm-12 col-xs-12 label-left">
      <label>Docs</label>
      <?php
         if(!empty($imageUploads)){
         	foreach($imageUploads as $proofs){

          $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
         //pre($ext);
         if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
         	echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/account/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/modules/account/uploads/'.$proofs['file_name'].'" alt="image" height="80" width="80"/><i </div></div>';
         }else if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' ){
         	echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/account/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/docX.png"  height="80" width="80"/><i class="fa fa-download"></i>
         </div></div>';
         }else if($ext == 'pdf'){
         	echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/account/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/PDF.png"  height="80" width="80"/><i class="fa fa-download"></i>
         	</div></div>';
         }else if($ext == 'xlsx' || $ext == 'xls'){
         	echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/account/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/excel.png"  height="80" width="80"/><i class="fa fa-download"></i>
         </div></div>';
         }
         }
         }
         ?>
   </div>
   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
      <div class="form-group">
         <div class="modal-footer">
            <button type="button" class="btn btn-default close_modal2" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
