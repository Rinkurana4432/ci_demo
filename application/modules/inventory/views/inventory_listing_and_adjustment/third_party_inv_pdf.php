<?php
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("DELIVERY CHALLAN");  
    $obj_pdf->SetHeaderData('TAX INVOICE', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(true);  
    $obj_pdf->SetAutoPageBreak(TRUE, 2);
	$obj_pdf->SetTopMargin(0);	
    $obj_pdf->SetFont('helvetica', '', 9);	 

	$company_data = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
	
	
	$user_data=getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'id');
	
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$obj_pdf->Image($image,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
//pre($company_data);die();
if($company_data->invoice_num_of_copies == 0){
	$print_no_copies = 3;
}else{
	$print_no_copies = $company_data->invoice_num_of_copies;
}
for($prnt = 1;$prnt<=$print_no_copies;$prnt++){
	
	
         if($prnt == 1){
			 $no_copies = '( ORIGINAL FOR RECIPIENT )';
		 }
		 if($prnt == 2){
			 $no_copies = '( DUPLICATE FOR TRANSPORTER )';
		 }
		 if($prnt == 3){
			 $no_copies = '( TRIPLICATE FOR SUPPLIER )';
		 }	 

    $obj_pdf->AddPage(); 
	 
	$content = '';
	$content1 = '';

	$sale_ledger = getNameById('ledger',$dataPdf->sale_ledger,'id');
	
	
	$sale_ledger_data = json_decode($sale_ledger->mailing_address,true);
	
	
	
	
	$mailing_city_for_jurdictions = getNameById('city',$sale_ledger_data[0]['mailing_city'],'city_id');
	
	
	$party_ledger = getNameById('ledger',$dataPdf->party_name,'id');
	 
   $party_add = json_decode($party_ledger->mailing_address,true);
   
	   foreach ($party_add as $key => $detaild) {
			if ($detaild['mailing_state'] == $dataPdf->party_state_id) {
				$mailing_address11 = $detaild['mailing_address'];
				
			}
	   }
	 
	
	$newDate = date("d-M-Y", strtotime($dataPdf->created_date));
	$buyer_order_date = date("d-M-Y", strtotime($dataPdf->buyer_order_date));
	if($buyer_order_date == '01-Jan-1970'){
		$buyer_order_date = '';
	}
	$dispatch_document_date = date("d-M-Y", strtotime($dataPdf->dispatch_document_date));
	if($dispatch_document_date == '01-Jan-1970'){
		$dispatch_document_date = '';
	}
	$datetime_issue_invoice = date("d-M-Y", strtotime($dataPdf->date_time_of_invoice_issue));
	$datetime_removal_goods = date("d/m/Y", strtotime($dataPdf->date_time_removel_of_goods));
	
	$party_ledger_purchaser = getNameById('state',$dataPdf->party_state_id,'state_id');
	
	$party_ledger_purchaser11 = $party_ledger_purchaser->state_name;
	
	
	
	if($dataPdf->challan_type == 0){
		$challan_type = 'DILIVERY CHALLAN ( RETURNABLE )';
	}else{
		$challan_type = 'DILIVERY CHALLAN ( Non RETURNABLE )';
	}
	
	if($company_data->term_and_conditions == ''){
		$termandCondi = 'N/A';
	}else{
		$termandCondi = $company_data->term_and_conditions;
	}
	//Material Data into Array
	$materialDetail =  json_decode($dataPdf->descr_of_goods,true);	
	
	
			$subTotal=0;
			$count=0;
			$mat_count = '';
			$data2 = array();
		
			foreach($materialDetail as $material_detail){

				$ww =  getNameById('uom', $material_detail['UOM'],'id');
				$uom = !empty($ww)?$ww->ugc_code:'';
			
				$data2[$count]['mat_id_'.$count] =  $material_detail['material_id'] ;
				$data2[$count]['mat_qty_'.$count] =  $material_detail['quantity'] ;
				$data2[$count]['mat_uom_'.$count] =   $uom;
							
				$data2[$count]['mat_hsnsac'.$count] =  $material_detail['hsnsac'] ;				
				$data2[$count]['mat_descrption'.$count] =  $material_detail['descr_of_goods'] ;				
				$data2[$count]['mat_rate_'.$count] =  $material_detail['rate'] ;				
				$data2[$count]['mat_prc_total_'.$count] =  $material_detail['tax'] * $material_detail['rate'];				
				$data2[$count]['Amount_'.$count] =  $material_detail['amount'] ;				
				$count++;
			}
		$divide = $count/4;
		
			
		$after_divide =  round($divide);
		
		if($after_divide <=  1){
			$after_divide = 1;
		}
		
		if ( $count >= 0 ){  //If there are more than 0 terms
	
			$k =0;
			$sno = 1;
             for ($j = 0; $j < $after_divide; $j++){
				$newDate = date("d / m / Y", strtotime($dataPdf->challan_date));
	//$sale_ledger->name // Convert name Mailing Name by Maninder 
	//Header Content
	//<td colspan="1"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
	// <td colspan="4" rowspan="4"><br><strong>'.$sale_ledger_data[0]['mailing_name'].'</strong><br>'.$sale_ledger_data[0]['mailing_address'].'<br><strong>GSTIN:</strong>'.$sale_ledger->gstin.'<br>State Name: '.$statename.',<br>Contact:  '.$sale_ledger->phone_no.','.$sale_ledger->mobile_no.'<br>Email:  '.$sale_ledger->email.'<br>Website:  '.$sale_ledger->website.'</td>
    $content .= '
			
		<table>
			<tr>
				<td  align="center"><img src="'.$companyLogo.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
			</tr>
			<tr>
				<td colspan="10"><div><h4 align="center">'.$challan_type.'</h4><span style="text-align:right; font-size:7px;">'.$no_copies.'</span></div></td>
			</tr>
			
		</table>
		<table border="1" cellpadding="2">
			<tr>
				
				<td colspan="4" rowspan="4"><strong>Consignee Address : </strong><br><strong>'.$party_ledger->name.'</strong><br>'.$mailing_address11.'<br><strong>GSTIN:</strong>'.$party_ledger->gstin.'<br>State Name :  '.$party_ledger_purchaser11.',<br>Contact :  '.$party_ledger->phone_no.','.$party_ledger->mobile_no.'<br>Email :  '.$party_ledger->email.'<br>Website :  '.$party_ledger->website.'</td>
				
				<td colspan="2" height="30"><strong>Challan Number No:</strong></td>
				<td colspan="2" height="30">'.$dataPdf->challan_num.'</td>
			</tr>
			<tr></tr>
			<tr>
				<td colspan="2" height="30"><strong>Challan Issue Date</strong></td>
				<td colspan="2" height="30">'.$newDate.'</td>
			</tr>
			<tr>
				<td colspan="2" height="30"><strong>Vehicle Reg No.</strong></td>
				<td colspan="2" height="30">'.$dataPdf->vehicle_reg_no.'</td>
			</tr>
			<tr>';
			
				$content .='<td colspan="4" rowspan="3"></td>';
		
			$content .='<td colspan="2"><strong>Transport Phone</strong>&nbsp;<br/>'.$dataPdf->transport.' </td>
						<td colspan="2">'.$dataPdf->transporter_phone.' </td>
			</tr>
			
			<tr>
				<td colspan="4" height="80"><strong>Terms Of Delivery </strong><br>'.$dataPdf->terms_of_delivery.'</td>
				
			</tr>
			<tr></tr>
			
			
			
			
			<tr>
				<th width="30px" align="center"  height="20"><strong>Sl No.</strong></th>
				<th width="110px" align="center" height="20"><strong>Description of Goods</strong></th>
				<th width="70px" align="center"  height="20"><strong>HSN/SAC</strong></th>
				<th width="70px" align="center"  height="20"><strong>QTY / UOM</strong></th>
				<th width="75px" align="center"  height="20"><strong>Rate</strong></th>
				<th width="70px" align="center"  height="20"><strong>Per</strong></th>
				<th width="86px" align="center"  height="20"><strong>Total Amt.</strong></th>
			</tr></table>';
			
			
			//Items Details
			
			$materialDetail =  json_decode($dataPdf->descr_of_goods);																
			$subTotal=0;
			$no=1;
			$total_hsnsac_code_count = 0;
			$content .='<table border="1" cellpadding="2">';
				
				
				
			
			for($i = 0 ;$i<4;$i++){
				
				$material_id=$data2[$k]['mat_id_'.$k];
				$materialName=getNameById('material',$data2[$k]['mat_id_'.$k],'id');	
				$subtotal = $data2[$k]['mat_rate_'.$k] * $data2[$k]['mat_qty_'.$k];
				//pre($materialName);
               /* if($subTotal == 0){
					$subTotal = '';
						<td width="110px">'.$materialName->material_name.'</td>
						<td width="110px" >'.$materialName->material_name.'<br/><span style="font-size:8px;margin-lefft:20px;">'.$materialName->descr_of_goods.'</span></td>
				}*/
				
				 if($data2[$k]['mat_qty_'.$k] != ''){

				 	$ww =  getNameById('uom', $data2[$k]['mat_uom_'.$k],'id');
														$uom = !empty($ww)?$ww->ugc_code:'';
					//pre($data2);die();
				$content .= '<tr>
					<td  width="30px" align="center">'.$sno++.'</td>
					<td width="110px">'.$materialName->material_name.'<br/><span style="font-size:8px;margin-lefft:20px;">'.$data2[$k]['mat_descrption'.$k].'</span></td>
					<td width="70px" align="center">'.$data2[$k]['mat_hsnsac'.$k].'</td>
					<td width="70px" align="center">'.$data2[$k]['mat_qty_'.$k]. ' / '.$uom.'</td>
					<td width="75px" align="center">'.$data2[$k]['mat_rate_'.$k].'</td>
					<td width="70px" align="center"><span style="font-size:11px !important;">'.$data2[$k]['mat_uom_'.$k].'</span></td>
					<td width="86px" align="center">'.number_format($data2[$k]['mat_qty_'.$k] * $data2[$k]['mat_rate_'.$k]).'</td>
				</tr>';	
				$k++;
				 }
			}

		
			
				
				if($j == $after_divide-1){
					
					
					$content .= '<tr>						
						<td colspan="6" align="right"><strong>Grand Total </strong> </td>
						<td align="center">'.number_format($dataPdf->challan_total_amt).'</td>
					</tr>';
					
					
				
			}	
				
				
				$sno = $sno-1; 
				/* Calculation amount in words */
				$number = $dataPdf->challan_total_amt;
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
			//<td colspan="2" align="center">Integrated Tax <br/><table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center">Total Tax Amount</td>
		if($j == $after_divide-1){
					
			$content .= '<tr><td colspan="7">Amount Chargeable(in Words)<br><b>'. $result . "Only".'</b></td></tr>';
			
			
	}
	
			
			$content .='<tr >
						<td class="align-right"  valign="bottom" colspan="7" style="text-align:right;border:1px solid #000;">
				for '.$company_data->name.'<br><br><br><br><br><br>(Authorized Signatory)</td>
					
						
			</tr>';
				
    
    $content .= '</table>';
	
	if($j != $after_divide-1){
		$content .='<table><tr><td colspan="6" align="right">Continued.......</td></tr></table>';
	}
	$sno++;
	}	
}	
 $obj_pdf->writeHTML($content); 

}

    //$obj_pdf->writeHTML($content); 
	ob_end_clean();			
	// pre($content);
// die(); 
	$obj_pdf->Output('Challan.pdf', 'I');   
	
 ?> 