<!DOCTYPE html>
<html lang="en">
  <head>


  <?php
	$company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');
	#pre($company_data); die;
	$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	
	
						
    $supplierName=getNameById('supplier',$dataPdf->supplier_name,'id');	
    $state= getNameById('state',$supplierName->state,'state_id');
	
	?>
	<table>
			<tr>
				<td  align="center"><img src="<?php echo $companyLogo; ?>" alt="test alt attribute" width="60" height="50" border="0" ></td>
			</tr>
			<tr>
				<td colspan="1"><div style="margin-top: 15%;"><h2 align="center">PURCHASE ORDER</h2></div></td>
			</tr>
			
		</table>
		<table border="1" cellpadding="2">
		
			<tr>
				
				<td colspan="3" rowspan="2">
				<strong>Buyer :</strong> <br/><?php echo $company_data->name; ?><br><br>
				<strong>Delivery Address :</strong><br/><?php echo $dataPdf->delivery_address; ?><br><br>
				<strong>Contact :</strong><br/><?php echo $company_data->phone; ?><br><br>
				<strong>Website :</strong><br/><?php echo $company_data->website; ?></td>
				
				<td colspan="3"><strong>Created Date :</strong> &nbsp; <br/><?php echo ($dataPdf->created_date?date("j F , Y", strtotime($dataPdf->created_date)):'');?></td>
				
				<td colspan="3"><strong>Voucher No :</strong> &nbsp;<br/><?php echo $dataPdf->order_code; ?></td>
				
				
			</tr>
			<tr>
				<td colspan="3"><strong>Freight :</strong> &nbsp;<br/><?php echo $dataPdf->freight;?></td>
				<td colspan="3"><strong>Mode / Terms Of Payment :</strong> &nbsp;<br/><?php echo $dataPdf->payment_terms; ?><br><br><strong>Payment Date :</strong> &nbsp;<br/><?php echo ($dataPdf->payment_date?(date("j F , Y", strtotime($dataPdf->payment_date))):'');?> </td><br><br>
			</tr>
			<tr>
				<td colspan="3" rowspan="2"><strong>Supplier Name :</strong> <br><?php echo $supplierName->name; ?> <br><br><strong>Supplier Address:</strong> <br><?php echo $supplierName->address; ?> <br><br><strong>State :</strong><?php echo $state->state_name; ?></td>
				<td colspan="3"><strong>Order Date</strong> &nbsp;<br><?php echo ($dataPdf->date?date("j F , Y", strtotime($dataPdf->date)):''); ?></td>
				<td colspan="3"><strong>Expected Delivery Date :</strong> &nbsp;<br/><?php echo ($dataPdf->expected_delivery_date?date("j F , Y", strtotime($dataPdf->expected_delivery_date)):'');?></td>
			</tr>
			<tr>
				<td colspan="6"><strong>Terms Of Delivery :</strong> &nbsp;<?php echo $dataPdf->terms_delivery; ?></td>
			</tr>
			<tr><td colspan="10"><b style="font-size:12px;">Product Description</b></td></tr>
			<tr>
				<th width="30px" style="text-align:center;"><strong>S No.</strong></th>
				<th width="80px" style="text-align:center;"><strong>Material Name</strong></th>
				<th width="40px" style="text-align:center;"><strong>QTY</strong></th>
				<th width="55px" style="text-align:center;"><strong>UOM</strong></th>
				<th width="40px" style="text-align:center;"><strong>Unit Price </strong></th>
				<th width="40px" style="text-align:center;"><strong>Tax (%)</strong></th>
				<th width="70px" style="text-align:center;"><strong>Net. Amt.(Rs)</strong></th>
				<th width="65px" style="text-align:center;"><strong>Tax. Amt.(Rs)</strong></th>
				<th width="90px" style="text-align:center;"><strong>Total Amt.</strong></th>
			</tr>
			<?php 
			$no=1;	
			$materialDetail =  json_decode($dataPdf->material_name);																
				$subTotal=0;
				setlocale(LC_MONETARY, 'en_IN');
					foreach($materialDetail as $material_detail){
						if(!empty($material_detail->material_name_id)){
					
					$subTotal += $material_detail->sub_total;
					$subTotal_TAX += $material_detail->sub_tax;
					$Total+=$material_detail->total;	
						$material_id=$material_detail->material_name_id;
						$materialName=getNameById('material',$material_id,'id');	
			?>			
			<tr>
				<td><?php echo $no++; ?></td>
				
				<td><h5><?php echo $materialName->material_name;?></h5><br><?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></td>					
				<td><?php echo $material_detail->quantity; ?></td>
				<td><?php echo $materialName->uom; ?></td>
				<td><?php echo $pricedf = money_format('%!i', $material_detail->price);?> </td>
				<td><?php echo $material_detail->gst;?></td>
				<td><?php echo $sub_totaldf = money_format('%!i', $material_detail->sub_total); ?></td>
				<td><?php echo $sub_taxdf = money_format('%!i', $material_detail->sub_tax);?></td>
				<td><?php echo $totaldf = money_format('%!i', $material_detail->total);?></td>
					</tr>
				<?php 	
					}}
					$subTotala = money_format('%!i', $subTotal);
				?>	
			<tr>
				<td colspan="8" align="right"><strong>Sub Total  </strong> </td>
				<td>Rs.<?php echo  $subTotala; ?></td>
			</tr>
				 <?php
				 $subTotal_TAXa = money_format('%!i', $subTotal_TAX);
				 $Totala = money_format('%!i', $Total);
				 ?>
			<tr>
				<td colspan="8" align="right"><strong>Tax</strong> </td>
				<td>Rs.<?php echo   $subTotal_TAXa; ?></td>
			</tr>
			<tr>
				<td colspan="8" align="right"><strong>Total Amount </strong> </td>
				<td>Rs.<?php echo   $Totala;?></td>
			</tr>
			<?php 
				$freights = money_format('%!i', $dataPdf->freight);
				if($dataPdf->terms_delivery == 'To be paid by customer'){
			?>		
			<tr>
				<td colspan="8" align="right"><strong>Freight(If Any)</strong> </td>
				<td>Rs.<?php echo ($freights?$freights:0);?></td>
			</tr>
		<?php 	
			}
			
			$grand_totals = money_format('%!i', $dataPdf->grand_total);
			?>
			<tr>
				<td colspan="8" align="right"><strong>Other Charges(If Any)</strong> </td>
				<td>Rs.<?php echo ($freights?$freights:0);?></td>
			</tr>
			
			<tr>
				<td colspan="8" align="right"><strong>Grand Total </strong> </td>
				<td>Rs. <?php echo  $grand_totals; ?></td>
			</tr>
		<?php 	
			//number_format($dataPdf->grand_total)
			/* Calculation amount in words */
				$number = $dataPdf->grand_total;
				   $no = round($number);
				   $point = round($number - $no, 2) * 100;
				   $hundred = null;
				   $digits_1 = strlen($no);
				   $i = 0;
				   $str = array();
				   $words = array('0' => '', '1' => 'One', '2' => 'Two',
					'3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
					'7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
					'10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
					'13' => 'Thirteen', '14' => 'Fourteen',
					'15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
					'18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
					'30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
					'60' => 'Sixty', '70' => 'Seventy',
					'80' => 'Eighty', '90' => 'Ninety');
				   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
				   while ($i < $digits_1) {
					 $divider = ($i == 2) ? 10 : 100;
					 $number = floor($no % $divider);
					 $no = floor($no / $divider);
					 $i += ($divider == 10) ? 1 : 2;
					 if ($number) {
						$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
						$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
						$str [] = ($number < 21) ? $words[$number] .
							" " . $digits[$counter] . $plural . " " . $hundred
							:
							$words[floor($number / 10) * 10]
							. " " . $words[$number % 10] . " "
							. $digits[$counter] . $plural . " " . $hundred;
					 } else $str[] = null;
				  }
				  $str = array_reverse($str);
				  $result = implode('', $str);
				  $points = ($point) ?
					"." . $words[$point / 10] . " " . 
						  $words[$point = $point % 10] : '';
			/* Calculation amount in words */
			?>			  
			
			<tr><td colspan="9">Amount Chargeable(in Words)<br><b><?php echo $result; ?> Only</b></td></tr>
			<tr>
				<td colspan="2">Buyer GSTIN</td>
				<td colspan="7"><?php echo  $company_data->gstin;?></td>
			</tr>
			<tr>
				<td colspan="2">Supplier GSTIN</td>
				<td colspan="7"><?php echo  $supplierName->gstin;?></td>
			</tr>
			<tr>
				<td colspan="2">Buyer PAN Card No.</td>
				<td colspan="7"><?php echo  $company_data->company_pan;?></td>
			</tr>
			<tr style="height:2000px">
                <td colspan="4"><h2>Terms & Conditions</h2>
					<p><?php echo  $dataPdf->terms_conditions;?></p>
				</td>
					<td class="align-bottom"  valign="bottom" colspan="6" style="text-align:right;">
				for <?php echo  $company_data->name;?><br><br><br>(Authorized Signatory)</td>
						
			</tr>  
    </table>
	<table><br><br><tr rowspan="2"><td  align="center"> This is computer generated Purchase Order does not require signature </td></tr></table>	
