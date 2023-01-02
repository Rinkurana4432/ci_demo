<style>
.vertical-border .item.form-group {
    overflow: auto;
}
h3.Material-head {
    margin-bottom: 30px;
}   
</style>
<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<h3 class="Material-head">Debit Note<hr></h3>
<?php 
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

$mrnid = $this->uri->segment(3);
$matid = $this->uri->segment(4);

 

$debitnoteDtl = getNameById('mrn_detail',$mrnid,'id');   


$matdetail = json_decode($debitnoteDtl->material_name,true);
$debitnoteAmt = 0;
foreach($matdetail as $matamt){

	if(!empty($matamt['defectedQty']) && $matamt['material_name_id'] == $matid ){
		
		$debitnoteAmt += 	$matamt['price'] * $matamt['defectedQty'];
	}
}

?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/save_debitNote" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
<div class="col-md-6 col-xs-12 col-sm-6 vertical-border">
      <div class="item form-group">
	        <label class=" col-md-3 col-sm-12 col-xs-12" for="debitNoteNo">Debit Note Number <span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
			   <input  class="form-control col-md-7 col-xs-12" value="<?php  
					$p_Data = getDbitcrditNoteNumber('debitnote_tbl',$this->companyGroupId ,'created_by_cid',1);
					$purchase_bill_no = $p_Data->id + 1;
					echo sprintf("%04s", $purchase_bill_no);


			   ?>" name="debitNoteNo" placeholder="Debit Note No" required="required">
		    </div>
	  </div>
	  <div class="item form-group">
	       <label class=" col-md-3 col-sm-12 col-xs-12" for="date">Debit Note Date</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
			   <input type="text" id="cr_date" class="form-control col-md-7 col-xs-12" name="date" value="<?php echo $debitnoteDtl->bill_date ?>" placeholder="Credit Note Date">
		    </div>
	  </div>
	  <!-- onchange="getcustomer_purchaseBill(event,this);" -->
	  <div class="item form-group">
	       <label class="col-md-3 col-sm-12 col-xs-4" for="parent_ledger">Supplier</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
			  <select class="itemName form-control selectAjaxOption select2"  required="required" name="supplier_id" data-id="ledger" data-key="id" data-fieldname="name" data-where="(save_status = 1) AND (created_by_cid=<?php echo $this->companyGroupId; ?> AND created_by_cid != 0 AND activ_status = 1   AND 	account_group_id = 55)"  width="100%" >
			  <?php 
			  if(!empty($debitnoteDtl->supplier_name)){
					$party_name = getNameById('ledger',$debitnoteDtl->supplier_name,'supp_id');
					
					echo '<option value="'.$party_name->id.'" selected>'.$party_name->name.'</option>';
				}
			  
			  ?>
			  </select>
		    </div>
	  </div>
	  <?php $supp_email = '';
				if(!empty($debitnoteDtl->supplier_name)){
					$party_name = getNameById('ledger',$debitnoteDtl->supplier_name,'supp_id');
					 $supp_email = $party_name->email;
					
					
				}
				?>
	  <div class="item form-group">
	    <label class="col-md-3 col-sm-12 col-xs-4" for="supplier_email">Email</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
			  <input type="text" value="<?php echo $supp_email; ?>" id="supplier_email" name="supplier_email" class="itemName form-control">
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
	  <input type="hidden" value="" id="party_billing_state_id" name="party_billing_state_id">
	<input type="hidden" value="<?php if(!empty($supplierState[0]['mailing_state'])){  echo $supplierState[0]['mailing_state'];  }?>" id="sale_company_state_id" name ="sale_company_state_id">
	  <input type="hidden" value="1" name="PurchaseReturn_DN_ornot">
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
	     <label class=" col-md-3 col-sm-12 col-xs-12" for="ledgerID">Debit Amount <span class="required">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12">
			  <input type="text" id="crAmt" class="form-control col-md-7 col-xs-12" name="debitAMt" value="<?php echo $debitnoteAmt; ?>" placeholder="Debit Note Amount" >
		    </div>
	  </div>
	   <div class="item form-group">
	    <label class="col-md-3 col-sm-12 col-xs-4" for="comment">Comment</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
			  <textarea type="text" id="comment" name="comment" class="comment form-control"></textarea>
		    </div>
	  </div>
</div>
<hr>
<div class="bottom-bdr"></div>
<center>

<button type="reset" class="btn btn-default">Reset</button>
<button id="send" type="submit" class="btn btn-warning">Submit</button>
</center>
</div>
</form>