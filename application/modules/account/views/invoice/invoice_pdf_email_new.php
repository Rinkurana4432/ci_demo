<?php


//for($prnt = 1;$prnt<=2;$prnt++){
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// pre($obj_pdf);
// }
setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// $obj_pdf = new \TCPDF('P', 'pt', 'A4', true, 'UTF-8');
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("TAX INVOICE");
    $obj_pdf->SetHeaderData('TAX INVOICE', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 2);
	// $obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$obj_pdf->SetTopMargin(1);
    $obj_pdf->SetFont('helvetica', '', 9);

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$company_data=getNameById('company_detail',$this->companyGroupId,'id');


	$bank_info = json_decode($company_data->bank_details);
    $primarybnk  = $bank_info[0];


	$user_data=getNameById('user_detail',$_SESSION['loggedInUser']->u_id,'id');

	 $image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	// $obj_pdf->Image($image,2,4,10,10,'PNG');
	// $imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	// $obj_pdf->Image($imagesign,2,4,10,10,'PNG');
//pre($company_data);die();
if($company_data->invoice_num_of_copies == 0){
	$print_no_copies = 3;
}else{
	$print_no_copies = $company_data->invoice_num_of_copies;
}

$countPrintPage = count($print_no_copies);
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




	$party_ledger = getNameById('ledger',$dataPdf->party_name,'id');



   $party_add = json_decode($party_ledger->mailing_address,true);



	   foreach ($party_add as $key => $detaild) {

			//if ($detaild['mailing_state'] == $dataPdf->party_state_id) {

				$mailing_address11 = $detaild['mailing_address'];
				$parrty_country_id = $detaild['mailing_country'];
				$mailing_city_id = $detaild['mailing_city'];
				$gstin_no = $detaild['gstin_no'];
			//}
	   }

	 //die();

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
	$datetime_removal_goods = date("d-M-Y", strtotime($dataPdf->date_time_removel_of_goods));


	$party_ledger_purchaser = getNameById('state',$dataPdf->party_state_id,'state_id');
	$parrty_country_idd = getNameById('country',$parrty_country_id,'country_id');
	$parrty_city_idd = getNameById('city',$mailing_city_id,'city_id');

	$party_ledger_purchaser11 = $party_ledger_purchaser->state_name;




	$sale_address_details = json_decode($company_data->address,true);

	// pre($dataPdf);
	// die();
	foreach ($sale_address_details as $comapny_sale_address_ldger) {

			if ($comapny_sale_address_ldger['add_id'] == $dataPdf->sale_lger_brnch_id) {
				$saleaddress = $comapny_sale_address_ldger['address'];
				$compny_branch_name = $comapny_sale_address_ldger['compny_branch_name'];
				$sale_country_id = $comapny_sale_address_ldger['country'];
				$parrty_state_id = $comapny_sale_address_ldger['state'];
				$sale_city_id = $comapny_sale_address_ldger['city'];
				$company_gstin = $comapny_sale_address_ldger['company_gstin'];

			}
	   }

	//echo $compny_branch_name;die();



	$mailing_city_for_jurdictions = getNameById('city',$sale_city_id,'city_id');

	$sale_ledger = getNameById('ledger',$dataPdf->sale_ledger,'id');

	if($sale_address_details != '' ){
		$mailing_state = getNameById('state',$parrty_state_id,'state_id');
		$mailing_country = getNameById('country',$sale_country_id,'country_id');
		$mailing_city = getNameById('city',$sale_city_id,'city_id');
		$statename = $mailing_state->state_name;
		$countryname = $mailing_country->country_name;
		$mailingcity = $mailing_city->city_name;

	}else{
		$statename = '';
		$countryname = '';
		$mailingcity = '';

	}




	if($dataPdf->eway_bill_no != '' && $dataPdf->eway_bill_no != '0' ){
		$content1 .='<span>e-Way bill No.'.$dataPdf->eway_bill_no.'</span>';
	}


	if($company_data->term_and_conditions == ''){
		$termandCondi = 'N/A';
	}else{
		$termandCondi = $company_data->term_and_conditions;
	}
	//Material Data into Array


	//pre($dataPdf);die;

	$materialDetail =  json_decode($dataPdf->descr_of_goods,true);
	$data_charges_json = json_decode($dataPdf->charges_added,true);

	/*pre($materialDetail);die;*/

	$array_mrg = array_merge((array)$materialDetail,(array)$data_charges_json);



			$totalBasePrice = $totalDisWithCharge = $addCharges = $count = $totalWithoutTax = $subTotal=0;
			$mat_count = '';
			$data2 = [];
			$showDiscountTh = false;

			if( $array_mrg ){
				foreach($array_mrg as $discountData){
					if( isset($discountData['disctype']) ){
						$showDiscountTh = true;
						goto end;
					}
				}
			}
			end:

		/*	pre($array_mrg);die;*/

			foreach($array_mrg as $material_detail){
			//	pre($material_detail);
				$data2[$count]['mat_id_'.$count] =  $material_detail['material_id'] ;
				$data2[$count]['mat_qty_'.$count] =  $material_detail['quantity'] ;
				$data2[$count]['mat_uom_'.$count] =  $material_detail['UOM'] ;
				$data2[$count]['mat_tax_'.$count] =  $material_detail['tax'] ;
				$data2[$count]['mat_hsnsac'.$count] =  $material_detail['hsnsac'] ;
				$data2[$count]['mat_descrption'.$count] =  $material_detail['descr_of_goods'] ;
				$data2[$count]['mat_rate_'.$count] =  $material_detail['rate'] ;
				$data2[$count]['mat_prc_total_'.$count] =  $material_detail['tax'] * $material_detail['rate'];
				$data2[$count]['Amount_'.$count] =  $material_detail['amount'] ;
				$data2[$count]['particular_charges_name_'.$count] =  $material_detail['particular_charges_name'] ;
				$data2[$count]['charges_added_'.$count] =  $material_detail['charges_added'] ;
				$data2[$count]['sgst_amt_'.$count] =  $material_detail['sgst_amt'] ;
				$data2[$count]['cgst_amt_'.$count] =  $material_detail['cgst_amt'] ;
				$data2[$count]['igst_amt_'.$count] =  $material_detail['igst_amt'] ;
				$data2[$count]['amt_with_tax_'.$count] =  $material_detail['amt_with_tax'] ;
				$data2[$count]['alterqty_'.$count] =  $material_detail['alterqty'] ;
				$data2[$count]['sale_amount_'.$count] =  $material_detail['sale_amount'] ;

				if( $showDiscountTh ){ 
					$data2[$count]['disctype'.$count] = 'N/A';
					if( !empty($material_detail['disctype']) ){
						if( $material_detail['disctype'] == 'disc_value' ){
							$data2[$count]['disctype'.$count] = "Discount Value ({$material_detail['discamt']})";
							$discountAmt =  $material_detail['quantity'] * $material_detail['discamt'];

						}else{
							$data2[$count]['disctype'.$count] = "Discount Percent ({$material_detail['discamt']}%)";

							$discountAmt = (($material_detail['quantity'] * $material_detail['rate']) * ($material_detail['discamt'] )/100);

							/*$discountAmt = 'N/A';*/
						}
						$data2[$count]['discTotalAmt'.$count] = $discountAmt;
					}
				}

				$count++;
			}
		
		$divide = $count/4;


		// pre($sale_ledger_data);
		// die('fgf');

		$after_divide =  round($divide);
		if($after_divide <=  1){
			$after_divide = 1;
		}

		if ( $count >= 0 ){  //If there are more than 0 terms

			$k =0;
			$sno = 1;
             for ($j = 0; $j < $after_divide; $j++){
            if( $company_data->qr_code_img && $company_data->qr_code == 1 ){
				$img = $company_data->qr_code_img;
				$imgSrc = '<img style="float:left;" src="'.base_url("assets/modules/account/uploads/{$img}").'" width="30px" height="30px" />';
			}


	//$sale_ledger->name // Convert name Mailing Name by Maninder
	//Header Content

    $content .= '<table>
					<tr>
						<td><img src="'.$image.'" alt="test alt attribute" width="30" height="30" border="0" ></td>';
    $content .= '<td ><div><h4 align="center">Tax Invoice</h4><span style="text-align:center; font-size:7px;">'.$no_copies.'</span></div></td>';
	if( $company_data->qr_code_img && $company_data->qr_code == 1 ){
			$content .=	 '<td style="text-align:right;">'.$imgSrc.'</td>';
	}

	$content .=  '</tr>
			</table>
		<table border="1" cellpadding="2">
			<tr>
				<td colspan="4" rowspan="4"><br><strong>'.$compny_branch_name.'</strong><br>'.$saleaddress.'<br><strong>GSTIN:</strong>'.$company_gstin.'<br>Address : '.$mailingcity.','.$statename.' ( '.$countryname.' )<br>Contact:  '.$sale_ledger->phone_no.','.$sale_ledger->mobile_no.'<br>Email:  '.$sale_ledger->email.'<br>Website:  '.$sale_ledger->website.'</td>
				<td colspan="2">'.$content1.'<strong><br>Invoice No:  </strong> &nbsp;<br/>'.$dataPdf->invoice_num.'</td>
				<td colspan="2"><strong>Dated</strong> &nbsp;<br/>'.$datetime_issue_invoice.'</td>
			</tr>
			<tr>

			</tr>
			<tr>
				<td colspan="2"><strong>Buyers Order No</strong> &nbsp;<br> '.$dataPdf->buyer_order_no.'</td>
				<td colspan="2"><strong>Dated:</strong> &nbsp;<br> '.$buyer_order_date.'</td>
			</tr>
			<tr>
				<td colspan="2"><strong>Dispatch Document No.</strong> &nbsp;<br/>'.$dataPdf->dispatch_document_no.'</td>
				<td colspan="2"><strong>Delivery Note Date.</strong> &nbsp; '.$dispatch_document_date.'</td>
			</tr>
			<tr>';
			/*if($dataPdf->consignee_address != ''){
			$content .='<td colspan="4" rowspan="3"><strong>Consignee Address ( Bill To ): </strong>&nbsp;<br/>'.$dataPdf->consignee_address.' </td>';
			}else{*/
				$content .= '<td colspan="4" rowspan="3"><strong>Consignee Address ( Bill To ):';
				$content .= $shipAddress = '</strong><br><strong>'.$party_ledger->name.'</strong><br>'.$mailing_address11.'<br><strong>GSTIN:</strong>'.$gstin_no.'<br>Address :  '.$parrty_city_idd->city_name.','.$party_ledger_purchaser11.' ('. $parrty_country_idd->country_name.' )<br>Contact :  '.$party_ledger->phone_no.','.$party_ledger->mobile_no.'<br>Email :  '.$party_ledger->email.'<br>Website :  '.$party_ledger->website.'</td>';
			/*}*/

			/*pre($dataPdf);die;*/

			if($dataPdf->consignee_address != ''){

				$ship_ledger = getNameById('ledger',$dataPdf->consignee_name,'id');

				$shipMail = json_decode($ship_ledger->mailing_address);
				if( isset($shipMail) && !empty($shipMail) ){
					$shipMail = $shipMail[0];
					$Shipmailing_country = getSingleAndWhere('country_name','country',['country_id' => $shipMail->mailing_country ]);
					$Shipmailing_state   = getSingleAndWhere('state_name','state',['state_id' => $shipMail->mailing_state ]);
					$Shipmailing_city    = getSingleAndWhere('city_name','city',['city_id' => $shipMail->mailing_city ]);

					$shipAddress = '</strong><br><strong>'.$shipMail->mailing_name.'</strong><br>'.$shipMail->mailing_address.'<br><strong>GSTIN:</strong>'.$shipMail->gstin_no.'<br>Country Name :  '.$Shipmailing_country.',<br/>State Name :  '.$Shipmailing_state.',<br/>City :  '.$Shipmailing_city.'<br>Contact :  '.$ship_ledger->phone_no.','.$ship_ledger->mobile_no.'<br>Email :  '.$ship_ledger->email.'<br>Website :  '.$ship_ledger->website.'</td>';
				}

			}

			$transportType = "N/A";
			if( !empty( $dataPdf->transport ) ){
				switch ($dataPdf->transport) {
					case 1:
						$transportType = 'Road';
					break;
					case 2:
						$transportType = 'Rail';
					break;
					case 3:
						$transportType = 'Air';
					break;
					case 4:
						$transportType = 'Ship';
					break;
				}
			}

			if($dataPdf->gr_date==''){
				$gr_date='';
			}else{
				$gr_date='&'.date('d-M-Y',strtotime($dataPdf->gr_date));
			}

			if($dataPdf->gr_no==''|| $dataPdf->gr_no==0){
				$gr_no='';
			}else{
				$gr_no=$dataPdf->gr_no;
			} 

			$content .='<td colspan="2"><strong>Transport</strong>&nbsp;<br/>'.$transportType.' </td>
						<td colspan="2"><strong>Driver Mobile No.</strong>&nbsp;<br/>'.$dataPdf->party_phone/*$dataPdf->transport_driver_pno*/.' </td>
			</tr>
			<tr>
				<td colspan="2"><strong>GR No & Date</strong>&nbsp;'.$gr_no.''.$gr_date.'</td>
				<td colspan="2"><strong>Motor Vehicle No.</strong>&nbsp;<br/>'.$dataPdf->vehicle_reg_no.' </td>

			</tr>
			<tr>
				<td colspan="2"><strong>Date of Issue of Invoice</strong> &nbsp;<br>'.$datetime_issue_invoice.'</td>
				<td colspan="2"><strong>Date of Removal of Goods</strong> &nbsp;<br>'.$datetime_removal_goods.'</td>
			</tr>
			<tr><td colspan="4" rowspan="1"><strong>Consignee Address ( Ship To ):'

				. $shipAddress .

				'<td colspan="6"><strong>Terms Of Delivery </strong> &nbsp;<br>'.$dataPdf->terms_of_delivery.'</td>
			</tr>


			<tr>
				<th width="30px"><strong>Sl No.</strong></th>
				<th width="110px"><strong>Description of Goods</strong></th>
				<th width="70px"><strong>HSN/SAC</strong></th>
				<th width="40px"><strong>QTY</strong></th>
				<th width="60px"><strong>Rate</strong></th>';

			// discunt code end

		/*	if( $showDiscountTh ){
	$content .= '<th width="75px"><strong>Discount Type</strong></th>
				<th width="75px"><strong>Discount Value</strong></th>';
			}*/

			// discunt code end

	$content .=	'<th width="60px"><strong>Unit Discount</strong></th>
				<th width="70px"><strong>Total Amt. with Disc</strong></th>
				<th width="70px"><strong>Total Amt.</strong></th>
			</tr></table>';


			//Items Details

			$materialDetail =  json_decode($dataPdf->descr_of_goods);
			$subTotal=0;
			$no=1;
			$total_hsnsac_code_count = 0;
			$content .='<table border="1" cellpadding="2">';


			$discountArray = [];

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
					// pre($data2);die();
					$uomname = getNameById('uom',$data2[$k]['mat_uom_'.$k],'id');
						//$data2[$k]['mat_uom_'.$k]
						//pre($data2);die();
				$content .= '<tr>
					<td  width="30px">'.$sno++.'</td>
					<td width="110px" >'.$materialName->material_name.'<br/><span style="font-size:8px;margin-lefft:20px;">'.$data2[$k]['mat_descrption'.$k].'</span>';
					if( $showDiscountTh ){
			    	/*$content .= '<br>Discount Type : '.$data2[$k]['disctype'.$k].'
			    				 <br>Discount Amount : '.$data2[$k]['discTotalAmt'.$k];*/
			    	}
/*
                pre($data2);
                die;*/



				$content .='
					</td>
					<td width="70px">'.$data2[$k]['mat_hsnsac'.$k].'</td>
					<td width="40px">'.$data2[$k]['mat_qty_'.$k]. ' '. $uomname->ugc_code.'<br /><small>'.$data2[$k]['alterqty_'.$k].'</small></td>
					/* Save Sale Order invoice details Start 11-03-2022 */
					<td width="60px">'.$data2[$k]['mat_rate_'.$k].'</td> /* Save Sale Order invoice details End 11-03-2022 */';

				    $basePrice = ($data2[$k]['mat_qty_'.$k] * $data2[$k]['mat_rate_'.$k]);

                    $totalBasePrice += ($data2[$k]['mat_qty_'.$k] * $data2[$k]['mat_rate_'.$k]);

                    $totalDisWithCharge += round($data2[$k]['discTotalAmt'.$k] + chargeAmountPerMat($dataPdf->charges_added,$basePrice - $data2[$k]['discTotalAmt'.$k] ,$dataPdf->descr_of_goods),1);

                      
                     $unit=($data2[$k]['discTotalAmt'.$k] + chargeAmountPerMat($dataPdf->charges_added,$basePrice - $data2[$k]['discTotalAmt'.$k] ,$dataPdf->descr_of_goods));
                     $sale_amt=$basePrice-$unit;
                     $taxable_value[]=$sale_amt;
				// echo $data2[$k]['sale_amount_'.$k];
                    $total_igst_val += $sale_amt*($data2[$k]['mat_tax_'.$k] /100);
				$content .=	'<td width="60px">'.($data2[$k]['discTotalAmt'.$k] + chargeAmountPerMat($dataPdf->charges_added,$basePrice - $data2[$k]['discTotalAmt'.$k] ,$dataPdf->descr_of_goods)).'</td>
					<td width="70px">'.$sale_amt.'</td>
					<td width="70px">/* Save Sale Order invoice details Start 11-03-2022 */'.($data2[$k]['mat_qty_'.$k])*($data2[$k]['mat_rate_'.$k]). '/* Save Sale Order invoice details End 11-03-2022 */</td>
				</tr>';
                $totalWithoutTax += $data2[$k]['sale_amount_'.$k];
               
				$k++;
				 }
				
				if($data2[$k]['particular_charges_name_'.$k] != ''){
					$charge_name = getNameById('charges_lead',$data2[$k]['particular_charges_name_'.$k],'id');

					$charges_added_without_tax = $data2[$k]['charges_added_'.$k];
					if( $charge_name->type_charges == 'minus' ){
						$discountArray = [$data2[$k]['particular_charges_name_'.$k] => $charges_added_without_tax ];
					}
                    if( $charge_name->type_charges != 'minus' ){
                        $content .= '<tr>
                            <td  width="30px">'.$sno++.'</td>
                            <td width="110px" >'.$charge_name->particular_charges.'</td>
                            <td width="70px">'.$charge_name->hsnsac.'</td>
                            <td width="40px">1</td>
                            <td width="60px">'.$charges_added_without_tax.'</td>
                            <td width="60px">N/A</td>
                            <td width="70px">'.$charges_added_without_tax.'</td>
                            <td width="70px">'.$charges_added_without_tax.'</td>
                        </tr>';
                        $addCharges += $charges_added_without_tax;
                    }
				$k++;
				}

			}

		//$data2[$k]['Amount_'.$k]
		//$data2[$k]['mat_tax_'.$k] * $data2[$k]['mat_rate_'.$k]

			$invoice_amount_details =  json_decode($dataPdf->invoice_total_with_tax);

				$data_charges_for_taxes = json_decode($dataPdf->charges_added,true);

				$ttotal_Amount_with_charges = 0;
				$totalTaxCharge = $carges_taxx_igst = 0;
				$grand_total_with_tax = array();
				$$grand_total_charges_invoice_tax_half = array();
				foreach($data_charges_for_taxes as $tax_val){
					$charge_name_val = getNameById('charges_lead',$tax_val['particular_charges_name'],'id');
					if($charge_name_val->type_charges == 'plus' && $tax_val['sgst_amt'] == '' && $tax_val['cgst_amt'] == ''){
						//IGST
						$ttotal_Amount_with_charges +=  $tax_val['charges_added'];
						 $Charges_tax = $tax_val['amt_with_tax'] - $tax_val['charges_added'];

						 $carges_taxx_igst += $Charges_tax;

                         $totalTaxCharge += $tax_val['amt_tax'];

						 // $igst

						// $grand_total_with_tax  = $ttotal_Amount_with_charges + $total_igst;

					}else if($charge_name_val->type_charges == 'plus' && $tax_val['sgst_amt'] != '' && $tax_val['cgst_amt'] != ''){//CGST SGST
						 $ttotal_Amount_with_charges += $tax_val['charges_added'];
						$carges_taxx = $tax_val['amt_with_tax'] - $tax_val['charges_added'];
						$grand_total_charges_invoice_tax += $carges_taxx;
						 $grand_total_with_tax =  $ttotal_Amount_with_charges + $carges_taxx;
					}
				}

				// pre($grand_total_charges_invoice_tax);
				//die();


					/* Calculation For CGST and SGST*/


					$invoice_total_tax_cgst_sgst = $dataPdf->CGST + $dataPdf->SGST;
				      $totalTax22 = $grand_total_charges_invoice_tax + $invoice_total_tax_cgst_sgst;
				     $grand_total_charges_invoice_tax_half = $totalTax22/2;
					/* Calculation For CGST and SGST*/
					//die();
//pre($total_igst_val);die;
				if($j == $after_divide-1){

					if(!empty($data_charges_for_taxes)){ //when charges added
						 $subtotal_with_charges = $ttotal_Amount_with_charges + $invoice_amount_details[0]->total;

						if($dataPdf->CGST == 0 &&  $dataPdf->CGST == 0){
							$content .= '<tr>
								<td colspan="7" align="right"><strong>Total </strong> </td>
								<td>'.($addCharges + $totalBasePrice ).'</td>
							</tr>';
                            $content .= '<tr>
								<td colspan="7" align="right"><strong>Total Discount </strong> </td>
								<td>'.$totalDisWithCharge.'</td>
							</tr>';
                            $invoice_tax = $dataPdf->IGST;
                            $total_igst = $carges_taxx_igst + $invoice_tax;
                            $content .= '<tr>
								<td colspan="7" align="right"><strong>After Discount </strong> </td>
								<td>'.($addCharges + $totalBasePrice) - $totalDisWithCharge .'</td>
							</tr>';   
							$content .='<tr>
								<td colspan="7" align="right"><strong>IGST </strong> </td>
					
								<td>'.($total_igst_val+$carges_taxx_igst).'</td>
							</tr>';
							if($invoice_amount_details[0]->cess_all_total != '' || $invoice_amount_details[0]->cess_all_total != 0){
								$content .='<tr>
								<td colspan="7" align="right"><strong>CESS </strong> </td>
								<td>'.$invoice_amount_details[0]->cess_all_total.'</td>
							</tr>';
							}

							//$Total_amount_sum = $subtotal_with_charges + $total_igst_val+ $invoice_amount_details[0]->cess_all_total;
							$Total_amount_sum = ($addCharges + $totalBasePrice) - $totalDisWithCharge+ $total_igst_val+$carges_taxx_igst;

							if($invoice_amount_details[0]->tds_tax != 0){

							$content .='<tr>
									<td colspan="7" align="right"><strong>TCS </strong> </td>

									<td>'.(floor($invoice_amount_details[0]->tds_tax*100)/100).'</td>
								</tr>';
							$roundoff =  round($dataPdf->total_amount) - $dataPdf->total_amount;

								$content .='<tr>
									<td colspan="7" align="right"><strong>Round off </strong> </td>
									<td>'.$roundoff.'</td>
								</tr>';
							$grTotal =	$Total_amount_sum + $invoice_amount_details[0]->tds_tax;
							/*$content .='<tr>
									<td colspan="6" align="right"><strong>Grand Total </strong> </td>
									<td>'.round($grTotal)).'</td>
								</tr>';*/
							}else{
								$grTotal =	$Total_amount_sum + $invoice_amount_details[0]->tds_tax;
							/*$content .='<tr>
									<td colspan="6" align="right"><strong>Grand Total </strong> </td>
									<td>'.round($grTotal)).'</td>
								</tr>';*/
							}

						}else{

							$content .= '<tr>
							<td colspan="7" align="right"><strong>Sub Total  </strong> </td>
							<td>'.$invoice_amount_details[0]->total.'</td>
							</tr>';
						$content .='<tr>
							<td colspan="7" align="right"><strong>CGST </strong> </td>
							<td>'.$grand_total_charges_invoice_tax_half.'</td></tr>
							<tr><td colspan="7" align="right"><strong>SGST </strong> </td>
							<td>'.$grand_total_charges_invoice_tax_half.'</td>
							</tr>';
							if($invoice_amount_details[0]->cess_all_total != '' || $invoice_amount_details[0]->cess_all_total != 0){
								$content .='<tr>
								<td colspan="7" align="right"><strong>CESS </strong> </td>
								<td>'.$invoice_amount_details[0]->cess_all_total.'</td>
							</tr>';
							}
							$roundoff =  round($dataPdf->total_amount) - $dataPdf->total_amount;

							$content .='<tr>
								<td colspan="7" align="right"><strong>Round off </strong> </td>
								<td>'.$roundoff.'</td>
							</tr>';
							$Total_amount_sum = $subtotal_with_charges + $totalTax22 + $invoice_amount_details[0]->cess_all_total;
							if($invoice_amount_details[0]->tds_tax != 0){

							$content .='<tr>
									<td colspan="7" align="right"><strong>TCS </strong> </td>
									<td>'.(floor($invoice_amount_details[0]->tds_tax*100)/100).'</td>
								</tr>';
							$roundoff =  round($dataPdf->total_amount) - $dataPdf->total_amount;

								$content .='<tr>
									<td colspan="7" align="right"><strong>Round off </strong> </td>
									<td>'.$roundoff.'</td>
								</tr>';
							$grTotal =	$Total_amount_sum + $invoice_amount_details[0]->tds_tax;
							/*$content .='<tr>
									<td colspan="6" align="right"><strong>Grand Total </strong> </td>
									<td>'.round($grTotal)).'</td>
								</tr>';*/
							}else{
								$grTotal =	$Total_amount_sum + $invoice_amount_details[0]->tds_tax;
							/*$content .='<tr>
									<td colspan="6" align="right"><strong>Grand Total </strong> </td>
									<td>'.round($grTotal)).'</td>
								</tr>';*/
							}
						}


				}else{//when Charges not added
					$content .= '<tr>
								<td colspan="7" align="right"><strong>Total </strong> </td>
								<td>/* Save Sale Order invoice details Start 11-03-2022 */'.($addCharges + $totalBasePrice ).'/* Save Sale Order invoice details End 11-03-2022 */</td>
							</tr>';
                            $content .= '<tr>
								<td colspan="7" align="right"><strong>Total Discount </strong> </td>
								<td>/* Save Sale Order invoice details Start 11-03-2022 */ '.$totalDisWithCharge.'/* Save Sale Order invoice details End 11-03-2022 */</td>
							</tr>';
                            $invoice_tax = $dataPdf->IGST;
                            $total_igst = $carges_taxx_igst + $invoice_tax;
                            $content .= '<tr>
								<td colspan="7" align="right"><strong>After Discount </strong> </td>
								<td>/* Save Sale Order invoice details Start 11-03-2022 */'.($addCharges + $totalBasePrice) - $totalDisWithCharge .'/* Save Sale Order invoice details End 11-03-2022 */</td>
							</tr>';

					/*$content .= '<tr>
						<td colspan="7" align="right"><strong>After Discount</strong> </td>
						<td>'.$invoice_amount_details[0]->total).'</td>
					</tr>';*/


					if($dataPdf->CGST == 0 &&  $dataPdf->CGST == 0){
						$content .='<tr>
							<td colspan="7" align="right"><strong>IGST </strong> </td>
							<td>/* Save Sale Order invoice details Start 11-03-2022 */'.$dataPdf->IGST.'/* Save Sale Order invoice details End 11-03-2022 */</td>
						</tr>';
					}else{
							$content .='<tr>
							<td colspan="7" align="right"><strong>CGST </strong> </td>
							<td>/* Save Sale Order invoice details Start 11-03-2022 */'.$dataPdf->CGST.'/* Save Sale Order invoice details End 11-03-2022 */</td></tr>
							<tr><td colspan="7" align="right"><strong>SGST </strong> </td>
							<td>/* Save Sale Order invoice details Start 11-03-2022 */'.$dataPdf->SGST.'/* Save Sale Order invoice details End 11-03-2022 */</td>
						</tr>';
					}


					if($invoice_amount_details[0]->tds_tax != 0){
					$content .='<tr>
							<td colspan="7" align="right"><strong>TDS </strong> </td>
							<td>/* Save Sale Order invoice details Start 11-03-2022 */'.round($invoice_amount_details[0]->tds_tax).'/* Save Sale Order invoice details End 11-03-2022 */</td>
						</tr>';
					$roundoff =  round($dataPdf->total_amount) - $dataPdf->total_amount;

					$content .='<tr>
						<td colspan="7" align="right"><strong>Round off </strong> </td>
						<td>/* Save Sale Order invoice details Start 11-03-2022 */'.$roundoff.'/* Save Sale Order invoice details End 11-03-2022 */</td>
					</tr>';
					$grTotal =	$invoice_amount_details[0]->invoice_total_with_tax + $invoice_amount_details[0]->tds_tax;
					/*$content .='<tr>
							<td colspan="6" align="right"><strong>Grand Total </strong> </td>
							<td>'.round($grTotal)).'</td>
						</tr>';*/
					}else{
						$roundoff =  round($dataPdf->total_amount) - $dataPdf->total_amount;

					/*$content .='<tr>
						<td colspan="6" align="right"><strong>Round off </strong> </td>
						<td>'.$roundoff).'</td>
					</tr>';*/
					$grTotal =	$invoice_amount_details[0]->invoice_total_with_tax + $invoice_amount_details[0]->tds_tax;
					/*$content .='<tr>
							<td colspan="6" align="right"><strong>Grand Total </strong> </td>
							<td>'.round($grTotal)).'</td>
						</tr>';*/

					}

				 }
				 $discountValue = 0;
				 $discountArrayValue = array_sum($discountArray);
					if( $discountArrayValue > 0 ){
							$discountValue = $discountArrayValue;
					}

					$content .='<tr>
						<td colspan="7" align="right"><strong>Round off</strong> </td>
						<td>'.round($grTotal - (int)$grTotal,2 ).'</td>
					</tr>';

					$grTotal = $grTotal - $discountValue;
					$content .='<tr>
							<td colspan="7" align="right"><strong>Grand Total </strong> </td>
							<td>/* Save Sale Order invoice details Start 11-03-2022 */'.(int)$grTotal.'/* Save Sale Order invoice details End 11-03-2022 */</td>
						</tr>';
			}
				if($invoice_amount_details[0]->tds_tax != 0){
					$inwords = $grTotal;
				}else{
					//$inwords = $Total_amount_sum;
					$inwords = $grTotal;
				}

				$sno = $sno-1;
				/* Calculation amount in words */
				$number = $inwords;
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

			$content .= '<tr><td colspan="8">Amount Chargeable(in Words)<br><b>'. $result . "Only".'</b></td></tr>';
			$content .= '<tr><td colspan="6"><b>Outstanding Amount For '.$party_ledger->name.'</b></td><td colspan="2" style="text-align:center">'.$outStanding.'</td></tr>';
			if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){
			$content .= '<tr>
					<td align="center" colspan="2">HSN/SAC</td>
					<td align="center"  colspan="4">Taxable value </td>
					<td align="center" colspan="4">Central Tax <br/>
					<table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center" colspan="2">State Tax <br/>
					<table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td align="center">Total Tax Amount</td></tr>
					<tr>';
			}else{
				$content .= '<tr><td colspan="2" align="center">HSN/SAC</td><td colspan="2" align="center">Taxable <br> value </td>
			<td colspan="2" align="center">Integrated Tax <br/><table border = "1"><tr><td>Rate</td><td>Amount</td></tr></table></td><td colspan="2" align="center">Total Tax Amount</td></tr>
			<tr>';
			}

			$hsnsac_code = array();
			$taxable_sum1 = 0;
			$taxable_sum = 0;
			$total_tax_sum = 0;
			$total_tax_sum1 = 0;
			$Taxamount_total = 0;

			$materialDetaileee =  json_decode($dataPdf->descr_of_goods);
					foreach($materialDetaileee as $key=> $mat_val){

						$hsnsac_code = $mat_val->hsnsac;
						$mat_qty = $mat_val->quantity;
						$mat_rate = $mat_val->rate;
						//$taxable_val =$discount;
						// $taxable_val = $mat_val->sale_amount;
						$taxable_val = $taxable_value[$key];
						$mat_tax = $mat_val->tax;
					  //  $total_ttax = $mat_val->added_tax_Row_val;
						$total_ttax =($taxable_value[$key])*$mat_val->tax/100;
						$cgst_sgst = $total_ttax / 2;
						$cgst_sgst_tax = $mat_tax / 2;
						$total_tax_amount = $cgst_sgst * 2;
						$Taxamount_total += $cgst_sgst;

				if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){
						$content .='<tr>
						<td colspan="2" align="center">'.$hsnsac_code.'</td>
						<td colspan="2" align="center">'.$taxable_val.'</td>
						<td align="center">'.$cgst_sgst_tax.'%</td>
						<td align="center">'.$cgst_sgst.'</td>
						<td align="center">'.$cgst_sgst_tax.'%</td>
						<td align="center">'.$cgst_sgst.'</td>
						<td colspan="3" align="center">'.$total_tax_amount.'</td></tr>';

						$taxable_sum+= $taxable_val;
						$total_tax_sum+= $total_ttax;
					}else{

						$content .='<tr>
						<td colspan="2" align="center">'.$hsnsac_code.'</td>
						<td colspan="2" align="center">/* Save Sale Order invoice details Start 11-03-2022 */'.$taxable_val.'/* Save Sale Order invoice details End 11-03-2022 */</td>
						<td align="center">'.$mat_tax.'%</td>
						<td align="center" >/* Save Sale Order invoice details Start 11-03-2022 */'.$total_ttax.'/* Save Sale Order invoice details Start 11-03-2022 */</td>
						<td align="center" colspan="3">/* Save Sale Order invoice details Start 11-03-2022 */'.$total_ttax.'/* Save Sale Order invoice details End 11-03-2022 */</td></tr>';

						$taxable_sum += $taxable_val;

					    $total_tax_sum += $total_ttax;
					}
	}
	 //die;
				//For charges Details
				$data_charges_data = json_decode($dataPdf->charges_added,true);
				$freight_taxable_amt = array();
				$total_charges_amt = 0;
				$freaight_tax_sum = 0;

				foreach($data_charges_data as $get_charge_data){
					$charge_name_val = getNameById('charges_lead',$get_charge_data['particular_charges_name'],'id');
					if($charge_name_val->type_charges == 'plus' && $get_charge_data['sgst_amt'] != '' &&  $get_charge_data['cgst_amt'] != ''){
						$charge_name_Data = getNameById('charges_lead',$get_charge_data['particular_charges_name'],'id');
					    $freight_taxable_amt = $get_charge_data['amt_with_tax'] - $get_charge_data['charges_added'];
						  $freight_amount_half += $freight_taxable_amt/2;
						  $freaight_tax_sum += $freight_taxable_amt;

						$total_charges_amt += $get_charge_data['charges_added'];
						$content .='<tr>
						<td colspan="1" align="center">'.$charge_name_Data->hsnsac.'</td>
						<td align="center">'.$get_charge_data['charges_added'].'</td>
						<td align="center">'.$get_charge_data['sgst_amt'].'%</td>
						<td align="center">/* Save Sale Order invoice details  11-03-2022 */'.($freight_taxable_amt/2).'/* Save Sale Order invoice details  11-03-2022 */</td>
						<td align="center">'.$get_charge_data['cgst_amt'].'%</td>
						<td align="center">/* Save Sale Order invoice details  11-03-2022 */'.($freight_taxable_amt/2).'/* Save Sale Order invoice details  11-03-2022 */</td>
						<td align="center">/* Save Sale Order invoice details  11-03-2022 */'.$freight_taxable_amt.'/* Save Sale Order invoice details  11-03-2022 */</td></tr>';

					}else if($charge_name_val->type_charges == 'plus' && $get_charge_data['sgst_amt'] == '' &&  $get_charge_data['cgst_amt'] == ''){
						$charge_name_Data = getNameById('charges_lead',$get_charge_data['particular_charges_name'],'id');
					    $freight_taxable_amt = $get_charge_data['amt_with_tax'] - $get_charge_data['charges_added'];

						$total_charges_amt += $get_charge_data['charges_added'];
						$content .='<tr>
							<td colspan="3" align="center">'.$charge_name_Data->hsnsac.'</td>
							<td align="center">'.$get_charge_data['charges_added'].'</td>
							<td align="center">'.$get_charge_data['igst_amt'].'%</td>
							<td align="center">/* Save Sale Order invoice details  11-03-2022 */'.$freight_taxable_amt.'/* Save Sale Order invoice details  11-03-2022 */</td>
							<td align="center">/* Save Sale Order invoice details  11-03-2022 */'.$freight_taxable_amt.'/* Save Sale Order invoice details  11-03-2022 */</td></tr>';

							 $freaight_tax_sum += $freight_taxable_amt;


					}
				}
		//die();

				//condition if charges not Added
				if($freaight_tax_sum !=''){
					$freaight_tax_sum;
				}else{
					$freaight_tax_sum = 0;
				}

				if(!empty($freight_taxable_amt)){
					$charges_freight_total = $freight_amount_half;
				}else{
					$charges_freight_total = 0;
				}

				if(!empty($total_charges_amt)){
					$total_charges_amt;
				}else{
					$total_charges_amt = 0;
				}

				//condition if charges not Added
				/* Calculation amount in words */
				$number = $total_tax_sum + $freaight_tax_sum;
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
				  $resulttax = implode('', $str);
				  $points = ($point) ?
					"." . $words[$point / 10] . " " .
						  $words[$point = $point % 10] : '';
			/* Calculation amount in words */
			/* Calculation amount in words */




				//For charges Details

			$content .='
				</tr>';
				if($dataPdf->CGST != 0 &&  $dataPdf->CGST != 0){

					$content .='<tr>
								<td colspan="2" align="Right">Total</td>
								<td align="center" colspan="2">/* Save Sale Order invoice details  11-03-2022 */'.$taxable_sum + $total_charges_amt.'/* Save Sale Order invoice details  11-03-2022 */</td>
								<td align="center" colspan="1"></td>
								<td align="center" colspan="2">/* Save Sale Order invoice details  11-03-2022 */'.$Taxamount_total  + $charges_freight_total.'/* Save Sale Order invoice details  11-03-2022 */</td>
								<td align="center" colspan="1"></td>
								<td align="center" colspan="1">/* Save Sale Order invoice details  11-03-2022 */'.$Taxamount_total + $charges_freight_total.'/* Save Sale Order invoice details  11-03-2022 */</td>
								<td align="center" colspan="2">/* Save Sale Order invoice details  11-03-2022 */'.$total_tax_sum + $freaight_tax_sum.'/* Save Sale Order invoice details  11-03-2022 */</td>
							</tr>';
					$content .='<tr><td colspan="8">Tax Amount (in Words)<br><b>'. $resulttax . "Only".'</b></td></tr>';
				}else{
					$content .='<tr>
								<td colspan="2" align="Right">Total</td>
								<td colspan="2" align="center">/* Save Sale Order invoice details  11-03-2022 */'.$taxable_sum + $total_charges_amt.'/* Save Sale Order invoice details  11-03-2022 */</td>
								<td colspan="1" align="center"></td>
								<td colspan="1" align="center">/* Save Sale Order invoice details  11-03-2022 */'.$total_tax_sum + $freaight_tax_sum.'/* Save Sale Order invoice details  11-03-2022 */</td>
								<td colspan="2" align="center">/* Save Sale Order invoice details  11-03-2022 */'.$total_tax_sum + $freaight_tax_sum.'/* Save Sale Order invoice details  11-03-2022 */</td>
							</tr>';
				$content .='<tr><td colspan="8">Tax Amount (in Words)<br><b>'. $resulttax . "Only".'</b></td></tr>';

				}

	}

		$content .='<tr>
				<td colspan="2">Company PAN Card</td>
				<td colspan="7">'.$company_data->company_pan.'</td>
			</tr>
			<tr style="height:2000px">
                <td colspan="4"><h2><u> Declarations</u></h2>
					<p>'.$termandCondi.'</p>
				</td>
					<td class="align-bottom"  valign="bottom" colspan="4">
						<table>
							<tr>
								<td>
								Company`s Bank Details <br/>
								Bank Name           :  <strong>'.$company_data->bank_name.'<br></strong>
								A/c No              : <strong>'.$company_data->account_no.'<br></strong>
								Branch & IFS Code   : <strong>'.$company_data->account_ifsc_code.'<br></strong>
								</td>
							</tr>
						</table>
						<td class="align-bottom"  valign="bottom" colspan="3" style="text-align:right;border:1px solid #ddd;">
				for '.$company_data->name.'<br>(Authorized Signatory)</td>
					</td>

			</tr>';


    $content .= '</table>';
	$content .='<table><tr rowspan="2"><td  align="center"> <br>SUBJECT TO <b style="text-transform:uppercase!important;">'.$mailing_city_for_jurdictions->city_name.'</b> JURISDICTION <br> This is Computer Generated Invoice </td></tr></table>';

	if($j != $after_divide-1){
		$content .='<table><tr><td colspan="6" align="right" >Continued.......</td></tr><tr><td style="display: block; page-break-before: always;" ></td></tr></table>';
	}
	$sno++;
	}

}

//$obj_pdf->writeHTML($content,'<tcpdf method="AddPage" />', true, 0, true, 0);
 $obj_pdf->writeHTML($content);

}

    //$obj_pdf->writeHTML($content);
	//ob_end_clean();
    /*print($content);
die();*/
	//$obj_pdf->Output('aaa.pdf', 'F');
$obj_pdf->Output(FCPATH.'assets/modules/account/pdf_invoice/pdf_invoice.pdf', 'F');
 ?>
