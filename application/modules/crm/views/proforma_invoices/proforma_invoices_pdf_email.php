<!DOCTYPE html>
<html lang="en">
  <head>

<?php

//$obj_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');


$bank_info = json_decode($company_data->bank_details);
$primarybnk  = $bank_info[0];

//$image = base_url().'assets/modules/crm/uploads/alfalogo.jpg';
	

 $ci = & get_instance();
if($company_data->address != ''){
		$companyAddress = json_decode($company_data->address);
		$companyAddress = 'Address: '.$companyAddress[0]->address.', Country: '.getNameById('country',$companyAddress[0]->country,'country_id')->country_name.', State: '.getNameById('state',$companyAddress[0]->state,'state_id')->state_name.', City: '.getNameById('city',$companyAddress[0]->city,'city_id')->city_name.', Pincode: '.$companyAddress[0]->postal_zipcode;
	}else{
		$companyAddress = '';
	}


	$accountData = getNameById('account',$dataPdf->account_id,'id');
	$contactData = getNameById('contacts',$dataPdf->contact_id,'id');	  
	$products =  json_decode($dataPdf->product);
	$max_val_chk = array();
	foreach($products as $product){
	$matData = getNameById('material', $product->product, 'id');
	$mat_name = $matData->material_name;
	$chunks = explode('_', $mat_name);
	$max_val_chk[] = count($chunks);	
	}
	$discount_offered = json_decode($dataPdf->discount_offered);
	$discount_offeredHtml = '';
	if(!empty($discount_offered)){
		foreach($discount_offered as $do){
			$discount_offeredHtml .=$do.',';	
		}	
			$discount_offeredHtml = substr_replace($discount_offeredHtml ,"", -1);
	}	
	$dispatch_documents = json_decode($dataPdf->dispatch_documents);
	$dispatch_documentsHtml = '';
	if(!empty($dispatch_documents)){
	foreach($dispatch_documents as $dd){
		$dispatch_documentsHtml .=$dd.',';	
	}	
		$dispatch_documentsHtml = substr_replace($dispatch_documentsHtml ,"", -1);
	}
	
	

// Start Proforma Invoice number
$last_id = getLastTableId('proforma_invoice');
$rId = $last_id + 110;
$piCode = 'PIR_' . rand(1, 1000000) . '_' . $rId;
/************** Revised Purchase order generation ******************/
$currentRevisedPIChar = 'A';
$nextRevisedPIChar = chr(ord($currentRevisedPIChar) + 1);
$revisedPOCode = '';
$revisedPICode = '';
if ($dataPdf && $dataPdf->save_status == 1) {
	if($dataPdf->pi_code == ''){
		echo " ";
	}else{
		$pi_code_array = explode('_', $dataPdf->pi_code, 4);
//pre($pi_code_array);
//	foreach ($pi_code_array as $key => $value) {
//	echo "pi_code_array[".$key."] = ".$value."<br>";
//	}
// pre();

		// if($pi_code_array[2] == ''){
		if(count($pi_code_array) < 3){
			$currentRevisedPIChar = 'A';
			#$nextRevisedPOChar = chr(ord($currentRevisedPOChar) + 1);
			$revisedPICode = $dataPdf->pi_code.'_'.$currentRevisedPIChar.'(Revised)';
		}else if($pi_code_array[2] != ''){
			#echo $po_code_array[2];
			$orignalOrderCode = $pi_code_array[0].'_'.$pi_code_array[1].'_'.$pi_code_array[2];
			$currentRevisedPIChar = explode('(', $pi_code_array[2], 1);
			$nextRevisedPIChar = chr(ord($currentRevisedPIChar[0]) + 1);
			$revisedPICode = $orignalOrderCode.'_'.$nextRevisedPIChar.'(Revised)';
		}
	}
}
// echo $piCode;
// die;
// End Proforma Invoice number

// Get terms and conditions
$termsAndCondition = $ci->crm_model->get_data('termscond');

// Get Variant Images
$variantTypes =	$ci->crm_model->get_data('variant_types');
$variantImages = $ci->crm_model->get_data('variant_options');
$variantImages = $ci->crm_model->get_data('material_variants');
$packing_data1 = 0;
$matIDD = 0;
foreach($variantImages as $mages ){
if(!empty(json_decode($mages['packing_data']))){
$packing_data = json_decode($mages['packing_data']);
foreach($packing_data as $pp){
$packing_data1 .= $pp->packing_mat;
if(!empty($packing_data1)){
$matIDD = $mages['id'];
}
}
}
}

#echo $packing_data1;
$accountdata = getNameById('account',$dataPdf->account_id,'id');
$BuyerType = getNameById('types_of_customer',$accountdata->type_of_customer,'id');
$billingdata = json_decode($accountdata->new_billing_address); 

$companyLogo = base_url()."assets/modules/crm/uploads/alfalogo.jpg"; 
?>
<table style='width: 100%;font-size: 10px;font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;  border-spacing: 0;' border="1" cellpadding ="2" >

<tr>
<td colspan="9"><span style="font-size: 18px;margin-top: 5px;text-align:center;font-wight:bold;"><?php echo $company_data->name; ?> </span></td>
<td ><img src="<?php echo $companyLogo; ?>"  style="float: left;width: 80px;"></td>

</tr>
<tr>
<th colspan="10">
<strong><?php echo $companyAddress; ?></strong>
</th>
</tr>
<tr>
<td style="text-align:center;">DATE</td>
<td style="text-align:center;"><?php echo $dataPdf->order_date; ?> </td>
<td colspan="4" style="text-align:center;">Proforma invoice</td>
<td style="text-align:center;">Expected Delivery Date</td>
<td style="text-align:center;"><?php echo date("d-m-Y", strtotime($dataPdf->dispatch_date)); ?></td>
<td>PI NO:</td>
<td><?php echo $dataPdf->pi_code; ?></td>
</tr>
<tr>
<td colspan="4">TO</td>

<th colspan="6">Bank Details</th>
</tr>
<tr>
<td colspan="4">Buyer Name: <?php echo $accountdata->name; ?><br>
Phone Number : <?php echo$accountdata->phone; ?> <br>
Address : <?php echo $billingdata[0]->billing_street_1; ?><br>
State : <?php echo $billingdata[0]->state_name; ?><br>
City : <?php echo $billingdata[0]->city_name; ?><br>
Zipcode : <?php echo $billingdata[0]->billing_zipcode_1; ?></td>

<td colspan="6" >Account Name: <?php echo $company_data->name; ?><br>
Bank Name : <?php echo $primarybnk->account_no; ?><br>
Account Number: <?php echo $primarybnk->account_no; ?><br>
IFSC Code: <?php echo $primarybnk->account_ifsc_code; ?><br>
Branch Name: <?php echo  $primarybnk->branch; ?>
</td>
</tr>
<tr>
<th style="vertical-align: middle; text-align: center;">SL.No</th>
<th style="vertical-align: middle; text-align: center;">Product Code</th>
<th style="vertical-align: middle; text-align: center;">Product Image</th>
<?php

$max_val_chk = array();
foreach($products as $product){
$matData = getNameById('material', $product->product, 'id');
$mat_name = $matData->material_name;

// $mat_name = $product->product;
$chunks = explode('_', $mat_name);
if(count($chunks) == 4){
$colspan = '';
} elseif(count($chunks) == 3){
$colspan = '2';
} elseif(count($chunks) == 2){
$colspan = '3';
} elseif(count($chunks) == 1){
$colspan = '4';
}
$max_val_chk[] = count($chunks);	
} 
for ($i = 1; $i < max($max_val_chk); $i++) { ?>
<th style="vertical-align: middle; text-align: center;">Variant <?php echo $i; ?></th>
<?php } ?>
<th style="vertical-align: middle; text-align: center;">Description</th>
<th style="vertical-align: middle; text-align: center;">Quantity</th>
<?php 
if($BuyerType->id !=2){
	?>
	<th style="vertical-align: middle; text-align: center;">Box</th>
<?php  } ?>
<th style="vertical-align: middle; text-align: center;">Price</th>
<th colspan="'.$colspan.'"  style="vertical-align: middle; text-align: center;">Total</th>
</tr>

<tbody>

<?php	
									   
if(!empty($products)){
$j =  1;
$ck = $subtotal = $gst = $TotalPrdtQty = $TotalBox  = 0;
$imagepath = '';
foreach($products as $product){
	
$subtotal += $product->individualTotal;
$TotalBox += $product->box;
$TotalPrdtQty += $product->quantity;
$gst += $product->individualTotal*($product->gst/100);
if(!empty($dataPdf)){
$mat_type = json_decode($dataPdf->material_type_id);
$material_type_id = getNameById('material_variants',$mat_type[$ck],'id');
$materialItemCode = $material_type_id->item_code;
$variantData = $material_type_id->variants_data;
$variantDataValue = json_decode($variantData);
}
?>
<tr>
<td style="vertical-align: middle; text-align: center"><br><br><br><?php echo $j; ?></td>
<td style="vertical-align: middle; text-align: center"><br><br><br><?php echo $materialItemCode; ?> </td>
<td style="vertical-align: middle; text-align: center">
<?php 

$mat_name = $product->product;
$mat_details = getNameById('material', $mat_name, 'id');
$mat_id = $mat_details->id;
$attachments = $ci->crm_model->get_image_by_materialId('attachments', 'rel_id', $product->product);
 $aatt = base_url().'assets/modules/inventory/uploads/'.$attachments[0]['file_name'];
if(!empty($attachments)){ 
	?>
	<img style="width: 50px; height: 50px;" src="<?php echo $aatt; ?>">
<?php 	
}else{
	?>
	<img style="width: 50px; height: 50px;" src="">
<?php 
 }
 ?>
</td>
 <?php

$matData = getNameById('material', $product->product, 'id');
$mat_name = $matData->material_name;
//$mat_name = $product->product;
$chunks = explode('_', $mat_name);
for ($i = 1; $i < max($max_val_chk); $i++) {
$c =$i+1;
if($c > count($chunks)){
	?>
	<td style="vertical-align: middle; text-align: center"></td>
<?php	
} else {
$variants = getNameById('material_variants', $chunks[0], 'temp_material_name');
$variants_data = !empty($variants->variants_data) ? json_decode($variants->variants_data, true):'';
$variant_key = !empty($variants_data['variant_key']) ? $variants_data['variant_key']:array();
$variantKeyCount = count($variant_key);
for($k=1; $k<=$variantKeyCount; $k++){
$fieldname = $variant_key[$k][0];
$variants = getNameById_withmulti('variant_options', $chunks[$i], 'option_name', $fieldname, 'variant_type_name');
$variantOptionName = @$variants->option_name;
$variantImg = base_url().'/assets/modules/inventory/varient_opt_img/'.$variants->option_img_name;
$imagepath =  '<img style="width: 50px; height: 50px;" src="'.base_url().'/assets/modules/inventory/varient_opt_img/'.$variants->option_img_name.'">';
if(!empty($variants)){
	?>
<!--img style="width: 50px; height: 50px;" src="<?php// echo $variantImg; ?>"-->
<td style="vertical-align: middle; text-align: center"><?php echo $imagepath; ?><br><span><?php echo  $variantOptionName;?> </span></td>
<?php 
}
}
//echo $chunks[$i];
	
}

}

?>
	<td style="vertical-align: middle; text-align: center"><br><br><br><?php echo $product->description; ?></td>
	<td style="vertical-align: middle; text-align: center"><br><br><br><?php echo  $product->quantity; ?></td>
	<?php 
	if($BuyerType->id != 2){
		?>
		<td style="vertical-align: middle; text-align: center"><br><br><br><?php echo $product->box; ?></td>
 <?php 	} ?>
	<td style="vertical-align: middle; text-align: center"><br><br><br><?php echo  $product->price; ?></td>
	<td colspan="<?php echo  $colspan;?> "  style="vertical-align: middle; text-align: center"><br><br><br><?php echo  $product->individualTotal; ?></td>
	</tr>
	<?php
	$j++; $ck++; }
	}
	// die();
	if(!empty($dataPdf)){
		$account = getNameById('account',$dataPdf->account_id,'id');
		$type_of_customer = $account->type_of_customer;
		$type_of_customer_data = $ci->crm_model->get_data_byId('types_of_customer', 'id', $type_of_customer);
		$calcDiscount_val = $dataPdf->load_type;
		$pi_cbf = $dataPdf->pi_cbf;
		$pi_weight = $dataPdf->pi_weight;
		$pi_paymode = $dataPdf->pi_paymode;
		$pi_permitted = $dataPdf->pi_permitted;
		$special_discount = $dataPdf->special_discount;
		$freightCharges = $dataPdf->freightCharges;
		$advance_received = $dataPdf->advance_received;
		$extra_charges = $dataPdf->extra_charges;
		if(!empty($dataPdf->advance_received)){
			$advance_received = $dataPdf->advance_received;
		}else{
			$advance_received = 0;
		}
		 
			if($calcDiscount_val == 'none'){
				$discount_rate = 0;
			} else {
				$discount_rate = $type_of_customer_data->$calcDiscount_val;	
			}
		$discount_value = $subtotal*($discount_rate/100);
		$spd_value = $subtotal*($special_discount/100);
		$total = $subtotal - $discount_value - $spd_value;
		$gfc = $freightCharges*18/100;
		if($discount_value !=0){
			$AfterDiscount = $subtotal - $discount_value;
			$spd_value = $AfterDiscount*($special_discount/100);
			$total = $AfterDiscount - $spd_value;
			
			foreach($products as $getTax){
				$gst = $total*($getTax->gst/100);
				$grand_total = (float)$total+(float)$gst+(float)$freightCharges+(float)$gfc;
			}
			
			
		}
		
		
		
		
		
		
		
		$grand_total = $total+$gst+$freightCharges+$gfc;
		$remain_balance = $grand_total-$advance_received;
		$remain_balance = (int)$remain_balance + (int)$extra_charges;
	}
	
?>


<tr>												
<td colspan="7" rowspan="12">
<table style="width:100%;">
<tr><td style="border-bottom:1px solid #000;">Total Qty</td><td style="text-align: right;border-right:1px solid #000;border-bottom:1px solid #000;"><?php echo $TotalPrdtQty; ?></td><td style="border-bottom:1px solid #000;">Total Box </td><td style="text-align:right;border-bottom:1px solid #000;"><?php echo $TotalBox; ?></td></tr>
<?php
	if($BuyerType->id !=2){
		?>
		 <tr>
			<td>CBF </td>
			<td style="border-right:1px solid #000;text-align:right;"><?php echo   $pi_cbf; ?></td>
			<td>Weight </td>
			<td style="text-align:right;"><?php echo   $pi_weight; ?></td>
		   </tr>
	<?php } ?>
	
			<tr>
				<td  style="border-top:1px solid #000;" colspan="4">TERMS & CONDITION</td>
			</tr>
</table>
<?php echo $termsAndCondition[0]['content']; ?>
</td>
<td colspan="2">Sub Total</td>
<td colspan="1" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>   <?php echo money_format('%!i',$subtotal); ?></td>

</tr>
<tr>
<td colspan="2" >Discount (<?php echo $discount_rate; ?>)</td>
<td colspan="1" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$discount_value); ?></td>
</tr>
<tr>												
<td colspan="2">Special Discount  </td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$spd_value); ?></td>
</tr>
<tr>												
<td colspan="2">Total  </td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$total); ?></td>
</tr>
<tr>												
<td colspan="2">Tax</td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$gst); ?></td>
</tr>
<tr>												
<td colspan="2">Freight</td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$freightCharges); ?></td>
</tr>
<tr>												

<td colspan="2">GST on the Freight</td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$gfc); ?></td>
</tr>
<tr>												

<td colspan="2">TCS</td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>   0.00</td>
</tr>
<tr>												
<td colspan="2">Grand Total</td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$grand_total); ?></td>
</tr>
<tr>												

<td colspan="2">Advance</td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$advance_received); ?></td>
</tr>
<tr>												
<td colspan="2">Extra Charges</td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',$extra_charges); ?></td>
</tr>

<tr>												

<td colspan="2">Balance</td>
<td colspan="2" style="text-align:center;"><span style="font-family:dejavusans;text-align:left;">&#8377;</span>  <?php echo money_format('%!i',round($remain_balance)); ?></td>
</tr>

<tr>												
<td colspan="7">Thanking You,</td>
<td colspan="3">For <?php echo $company_data->name; ?><br><br>Note:This is an electronic quote. Signature not requiers.</td>

</tr>

</tbody>	
</table>