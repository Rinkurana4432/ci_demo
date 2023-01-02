<style>
   .vertical-border .item.form-group {
   overflow: auto;
   }
   h3.Material-head {
   margin-bottom: 30px;
   }
 @media(min-width:1024px)
{
.col-md-12.input_descr_wrap.label-box.mobile-view2.row_head {
display: flex;
align-items: stretch;
vertical-align: -webkit-baseline-middle;
}
.col-md-12.input_descr_wrap.label-box.mobile-view2.row_head .item.form-group {
    float: unset;
    display: flex;
} 
}
</style>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
 <?php 
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
 
 $mrnid = $this->uri->segment(3); 
 $matid = $this->uri->segment(4);

	$debitnoteDtl = getNameById('mrn_detail',$mrnid,'id'); 
	
	
	
	$dtls = getNameById('ledger',$debitnoteDtl->supplier_name,'supp_id');
	$supplierState = json_decode($dtls->mailing_address,true);
	
 ?>
 <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/savePurchase_return_DebitNote" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
   <div class="col-md-6 col-xs-12 col-sm-6 vertical-border">
      <div class="item form-group">
         <label class=" col-md-3 col-sm-12 col-xs-12" for="debitNoteNo">Debit Note Number <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="" class="form-control col-md-7 col-xs-12" value="<?php  
					$p_Data = getDbitcrditNoteNumber('debitnote_tbl',$this->companyGroupId ,'created_by_cid',0);
					$purchase_bill_no = $p_Data->id + 1;
					echo sprintf("%04s", $purchase_bill_no);


			   ?>" name="" placeholder="" required="required">
         </div>
      </div>
      <div class="item form-group">
         <label class=" col-md-3 col-sm-12 col-xs-12" for="date">Debit Note Date</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="debitnotedate" class="form-control col-md-7 col-xs-12" name="date" value="<?php echo $debitnoteDtl->bill_date ?>" placeholder="Debit Note Date">
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-4" for="parent_ledger">Supplier</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="itemName form-control selectAjaxOption select2 getsupplierState" required="required" name="supplier_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="" width="100%"  tabindex="-1" aria-hidden="true">
               <option value="">Select</option>
			   <?php 
			  if(!empty($debitnoteDtl->supplier_name)){
					$party_name = getNameById('ledger',$debitnoteDtl->supplier_name,'supp_id');
					
					echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
				}
			  
			  ?>
            </select>
         </div>
      </div>
	  <?php 
	  $supp_email = '';
		if(!empty($debitnoteDtl->supplier_name)){
			$party_name = getNameById('ledger',$debitnoteDtl->supplier_name,'supp_id');
			 $supp_email = $party_name->email;
		}
	?>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-4" for="supplier_email">Email</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" value="<?php echo $supp_email; ?>"  name="supplier_email" class="itemName form-control">
         </div>
      </div>
   </div>
   <div class="col-md-6 col-xs-12 col-sm-6 vertical-border">
      <div class="item form-group">
         <label class=" col-md-3 col-sm-12 col-xs-12" for="invoice_no">Purchase Bill No </label>
         <div class="col-md-6 col-sm-12 col-xs-12">
    
			<input type="text" value="<?php echo $debitnoteDtl->bill_no; ?>"  name="PurchaseBill_no" class="itemName form-control" readonly>
         </div>
      </div>
      <div class="item form-group">
         <label class=" col-md-3 col-sm-12 col-xs-12" for="ledgerID">Buyer <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
			<select class="itemName form-control selectAjaxOption select2 getBuyerState" required="required" name="buyerID" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid = 0 AND activ_status = 1)"  width="100%">
					<option value="">Select</option>
					<?php
						// if(!empty($DRDNDtl)){
							// $saleLedgerID = getNameById('ledger',$DRDNDtl->buyerID,'id');
							// echo '<option value="'.$saleLedgerID->id.'" selected>'.$saleLedgerID->name.'</option>';
						// }
					?>
				</select>
         </div>
      </div>
      <div class="item form-group">
         <label class=" col-md-3 col-sm-12 col-xs-12" for="ledgerID">Refrence No <span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input type="text" id="" class="form-control col-md-7 col-xs-12" name="debitAMt" value="<?php if(!empty($debitnoteDtl->refrence)){echo $debitnoteDtl->refrence;}else{ echo lastRefrenceNo('refrence','debitnote_tbl'); }  ?>" placeholder="Debit Note Amount" >
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-4" for="comment">Comment</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <textarea type="text" id="" name="comment" class="comment form-control"></textarea>
         </div>
      </div>
   </div>
	<input type="hidden" value="" id="party_billing_state_id" name="party_billing_state_id">
	<input type="hidden" value="<?php if(!empty($supplierState[0]['mailing_state'])){  echo $supplierState[0]['mailing_state'];  }?>" id="sale_company_state_id" name ="sale_company_state_id">
	 <input type="hidden" value="0" name="PurchaseReturn_DN_ornot">
   <hr>
   <div class="bottom-bdr"></div>
   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <h3 class="Material-head">
            Product Details  
            <hr>
        </h3>
      <div class="middle-box panel-body label-box ">
         <div class="col-md-12 input_descr_wrap label-box mobile-view2 row_head">
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Material Name</label>
            </div>
            <div class="col-md-2 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label>
            </div>
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="HSN/SAC">HSN/SAC</label>
            </div>
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="Quantity">Quantity</label>
            </div>
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Rate</label>
            </div>
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Disc. Type</label>
            </div>
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Disc. Amt.</label>
            </div>
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="Rate">Amt. After Desc.</label>
            </div>
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="Tax">Tax</label>
            </div>
            <div class="col-md-1 item form-group">
               <label class="col-md-12 col-sm-12 col-xs-12" for="UOM">UOM</label>
            </div>
            <div class="col-md-1 item form-group" style="border-right: 1px solid #c1c1c1;">
               <label class="col-md-12 col-sm-12 col-xs-12" for="Amount with Tax">Amount with Tax</label>
            </div>
         </div>
		 <?php 
			$matid = $this->uri->segment(4);
			$debitnoteDtl = getNameById('mrn_detail',$mrnid,'id'); 
			$matdetail = json_decode($debitnoteDtl->material_name,true);
			$debitnoteAmt = 0;
			foreach($matdetail as $matamt){
				if(!empty($matamt['defectedQty']) && $matamt['material_name_id'] == $matid ){
					
					
					$debitnoteAmt += 	$matamt['price'] * $matamt['defectedQty'];
					
					$matname = getNameById('material',$matid,'id'); 
					$hsnName = getNameById('hsn_sac_master',$matname->hsn_code,'id'); 
					$uomdata = getNameById('uom',$matamt['uom'],'id'); 
					
					$subtotal = ($matamt['price'] * $matamt['defectedQty']);
					
					$totalTax = ($subtotal*$matamt['gst'])/100;
					
					$totalAmtWithTax = $totalTax + $subtotal;
					
					
				
		?>
		<input type="hidden" value="<?php echo $totalTax; ?>" name="added_tax_Row_val[]" class="totalTaxValue">
		 <div class="scend-tr mailing-box col-md-12" style="padding: 0px;">
		       <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			       <input type="text" class="itemName form-control" name="material_name[]" required="required"  value="<?php echo $matname->material_name; ?>" readonly="">
			       <input type="hidden" class="itemName form-control" required="required" name="material_id[]" value="<?php echo $matid; ?>" readonly="">
			   </div>
			   <div class="item form-group col-md-2 col-sm-12 col-xs-12">
			        <input type="text" name="descr_of_goods[]" class="form-control col-md-1 " placeholder="Description Of Goods" value="" >
			   </div>
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			        <input type="hidden" name="" class="form-control col-md-1" placeholder="HSN/SAC" value="<?php echo $matname->hsn_code; ?>" readonly="">
			        <input type="text" name="hsnsac[]" class="form-control col-md-1" placeholder="HSN/SAC" value="<?php echo $hsnName->hsn_sac; ?>" readonly="">
			   </div>
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			        <input type="text" required="required" name="quantity[]" class="form-control col-md-1 " placeholder="Quantity" value="<?php echo $matamt['defectedQty']; ?>">
			   </div>
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			        <input type="text" required="required" name="rate[]" class="form-control col-md-1 " placeholder="Rate" value="<?php echo $matamt['price']; ?>">
					<input type="hidden" name="basic_Amt[]" class="form-control col-md-1 goods_descr_section" placeholder="Rate" value="<?php echo $matamt['price'] * $matamt['defectedQty']; ?>">
			   </div>
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			        <input type="text" name="" class="form-control col-md-1 " value="disc_value" readonly="">
			   </div>
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			        <input type="text" name="disctype[]" class="form-control col-md-1 " readonly="" placeholder="Disc Amt" value="">
			   </div>
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			       <input type="text" name="discamt[]" class="form-control col-md-1" readonly="" placeholder="After Disc Amt" value="">
			   </div>
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			       <input type="text" name="tax[]" class="form-control col-md-1" placeholder="Tax" value="<?php echo $matamt['gst'];?>" readonly="">
			       <input type="hidden" name="after_desc_amt[]" class="form-control col-md-1" placeholder="Tax" value="<?php echo $totalTax;?>" readonly="">
			   </div>
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			      <input type="text" name="UOM1[]" class="form-control col-md-1" readonly="" value="<?php echo $uomdata->uom_quantity; ?>">
			      <input type="hidden" name="UOM[]" class="form-control col-md-1" readonly="" value="<?php echo $matamt['uom'];?>">
			   </div>
			   
			   <div class="item form-group col-md-1 col-sm-12 col-xs-12">
			      <input type="text"  name="" class="form-control col-md-1" readonly="" placeholder="Amount" value="<?php echo $totalAmtWithTax; ?>">
			   </div>
		 </div>
		 <?php
			}
			}
		 ?>
      </div>
   </div>
   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
      <div class="col-md-12 col-sm-12 col-xs-12 tbllFooter" style="">
         <div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
            <div class="col-md-12 col-sm-12 col-xs-12 text-right">
               <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                  <span style="font-size:18px;font-weight:bold;">Subtotal  </span>
               </div>
               <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                  <input type="text" value="<?php echo $subtotal; ?>" name="subtotal[]" class="crnote_subtotal" style="border: none;" readonly="" placeholder="">
				  <input type="hidden" value="<?php echo $subtotal; ?>" name="subTotal_Amt">
                 
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 text-right charges_amount_row" style=""></div>
            <div class="col-md-12 col-sm-12 col-xs-12 text-right igstdata" style="display: none;">
               <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                  <span style="font-size:18px;font-weight:bold;">IGST </span>
               </div>
               <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                  <input type="text" class="crnote-total-taxIGST" value="" name="total_tax_IGST"  style="border: none;" readonly="" placeholder="">
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 text-right sgsttdata" style="display: none;">
               <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                  <span style="font-size:18px;font-weight:bold;">SGST </span>
               </div>
               <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                  <input type="text" value="" name="total_tax_SGST" class="crnote-total-taxSGST" style="border: none;" readonly="" placeholder="">
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 text-right cgsttdata" style="display: none;">
               <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                  <span style="font-size:18px;font-weight:bold;">CGST </span>
               </div>
               <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                  <input type="text" value="" name="total_tax_CGST" class="crnote-total-taxCGST" style="border: none;" readonly="" placeholder="">
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 text-right">
               <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                  <span style="font-size:18px;font-weight:bold;">Grand Total  </span>
               </div>
               <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                  <input type="text" value="<?php echo $totalAmtWithTax; ?>" name="grand_total" class="" style="border: none;" readonly="" placeholder="">
               </div>
            </div>
         </div>
      </div>
   </div>
<hr>
<center>
      <button type="reset" class="btn btn-default">Reset</button>
      <button id="send" type="submit" class="btn btn-warning">Submit</button>
</center>
</div>
</form>