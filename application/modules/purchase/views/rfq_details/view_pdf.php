<?php   
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("REQUEST FOR QUOTATION");  
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);  
    $obj_pdf->SetAutoPageBreak(TRUE, 10);  
    $obj_pdf->SetFont('helvetica', '', 9);	  
	#$company_data = getNameById('company_detail',$dataPdf->created_by,'id');
	$company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');
	#pre($company_data); die;
	$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	
	$obj_pdf->Image($companyLogo,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
						
    $supplierName=getNameById('supplier',$dataPdf->supplier_name,'id');	
    $state= getNameById('state',$supplierName->state,'state_id');
    $obj_pdf->AddPage(); 
    $content = ''; 
	#echo $companyLogo; die;
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	$brnch_name = getNameById_with_cid('company_address', $dataPdf->delivery_address, 'id','created_by_cid',$this->companyGroupId);
	// pre($dataPdf);
	// die();
    $content .= '
		<table>
			<tr>
				<td  align="center"><img src="'.$companyLogo.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
			</tr>
			<tr>
				<td colspan="1"><div style="margin-top: 15%;"><h2 align="center">REQUEST FOR QUOTATION</h2></div></td>
			</tr>
			
		</table>
		<table border="1" cellpadding="2">
		
			<tr>
				<td colspan="3" rowspan="2">
				<strong>Buyer :</strong> <br/>'.$company_data->name.'<br>
				<strong>Delivery Address :</strong><br/>'.$brnch_name->location.'<br>
				<strong>Contact :</strong><br/>'.$company_data->phone.'<br>
				<strong>Website :</strong><br/>'.$company_data->website.'<br>
				<strong>Email :</strong><br/>'.$company_data->email.'</td><td colspan="6"><strong>RFQ No :</strong> &nbsp;'.$dataPdf->indent_code.'<br/><strong>RFQ Issue Date :</strong> &nbsp; '.($dataPdf->created_date?date("j F , Y", strtotime($dataPdf->created_date)):'').'<br/><strong>RFQ Due Date :</strong> &nbsp; '.($dataPdf->created_date?date("j F , Y", strtotime($dataPdf->created_date)):'').'</td>
			</tr>
		
	        <tr>
				<td colspan="6"><strong>Supplier Name :</strong> <br>'.$supplierName->name.' <br><br><strong>Supplier Address:</strong> <br>'.$supplierName->address.' <br><br><strong>State :</strong>'.$state->state_name.'</td>
			</tr>
			<tr>
				<td colspan="6"><strong>Terms Of Delivery :</strong> &nbsp;'.$dataPdf->terms_delivery.'</td>
			</tr>
			<tr><td colspan="10"><b style="font-size:12px;">Product Description</b></td></tr>
			<tr>
				<th colspan="1" style="text-align:center;"><strong>S No.</strong></th>
				<th colspan="3"  style="text-align:center;"><strong>Material Name</strong></th>
				<th colspan="4"  style="text-align:center;"><strong>Description</strong></th>
				<th colspan="2"  style="text-align:center;"><strong>Quantity Request</strong></th>
			</tr>';
			$no=1;	
			$materialDetail =  json_decode($dataPdf->material_name);																
				$subTotal=0;
				setlocale(LC_MONETARY, 'en_IN');
					foreach($materialDetail as $material_detail){
						if(!empty($material_detail->material_name_id)){
					
				//	$subTotal += $material_detail->sub_total;
				//	$subTotal_TAX += $material_detail->sub_tax;
					//$Total+=$material_detail->total;	
						$material_id=$material_detail->material_name_id;
						$materialName=getNameById('material',$material_id,'id');	
						//$ww =  getNameById('uom', $materialName->uom,'id');
						//$uom = !empty($ww)?$ww->ugc_code:'';
			$content .= '<tr colspan="1" >
				<td>'.
					$no++.'
				</td>
				
				<td colspan="3" ><h5>'.$materialName->material_name.'</h5><br>'.(array_key_exists("description",$material_detail)?$material_detail->description:'').'</td><td colspan="4" >'.$material_detail->description.'</td>	
				<td colspan="2" >'.
					$material_detail->quantity.'
				</td>
					</tr>';}}

			$content .= '<tr>
				<td colspan="2">Buyer GSTIN</td>
				<td colspan="7">'.$company_data->gstin.'</td>
			</tr>
             <tr>
				<td colspan="2">Supplier GSTIN</td>
				<td colspan="7">'.$supplierName->gstin.'</td>
			</tr>			
			<tr>
				<td colspan="2">Buyer PAN Card No.</td>
				<td colspan="7">'.$company_data->company_pan.'</td>
			</tr>
			<tr style="height:2000px">
                <td colspan="4"><h2>Terms & Conditions</h2>
					<p>'.$dataPdf->terms_conditions.'</p>
				</td>
					<td class="align-bottom"  valign="bottom" colspan="6" style="text-align:right;">
				for '.$company_data->name.'<br><br><br>(Authorized Signatory)</td>
						
			</tr>';  
    
    $content .= '</table>';
$content .='<table><br><br><tr rowspan="2"><td  align="center"> This is computer generated Purchase Order does not require signature </td></tr></table>';	
    $obj_pdf->writeHTML($content); 
	  ob_end_clean(); 
	// Clean any content of the output buffer
	//print($content);die;
   //$obj_pdf->lastPage();
    $pdfFilePath = FCPATH . "assets/modules/account/pdf_invoice/order_pdf.pdf";
  $obj_pdf->Output($pdfFilePath, 'I');  
  
 ?> 