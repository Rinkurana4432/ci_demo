<?php 
$pdf->SetHeaderMargin(30);
$pdf->setPrintHeader(false);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);  
$pdf->SetTitle('Proforma Invoice');
$pdf->SetSubject('Proforma Invoice');
$dataPdf->created_by;
$company_data = getNameById('company_detail',$dataPdf->created_by,'id');
$image = base_url().'assets/modules/company/uploads/'. $company_data->logo;
$pdf->Image($image,8,9,30,'JPG');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$html = '<h1 style="color: #07026B; text-align:center;">PROFORMA INVOICE</h1>';
$pdf->writeHTML($html, true, false, true, false, '');
	$dataPdf->account_id;
	$accountData=getNameById('account',$dataPdf->account_id,'id');	
	$contactData=getNameById('contacts',$dataPdf->contact_id,'id');
	$paymentTerms = json_decode($dataPdf->payment_terms);
	$paymentTermHtml = '';
	if(!empty($paymentTerms)){
		foreach($paymentTerms as $paymentTerm){
			$paymentTermHtml .=$paymentTerm.',';	
		}	
		$paymentTermHtml = substr_replace($paymentTermHtml ,"", -1);
		
	}	
	
	$discount_offered = json_decode($dataPdf->discount_offered);
	$discount_offeredHtml = '';
	if(!empty($discount_offered)){
		foreach($discount_offered as $do){
			$discount_offeredHtml .=$do.',';	
		}	
		$discount_offeredHtml = substr_replace($discount_offeredHtml ,"", -1);
	}
	$dispatch_documents= json_decode($dataPdf->dispatch_documents);
	$dispatch_documentsHtml = '';
	if(!empty($dispatch_documents)){
		foreach($dispatch_documents as $dispatch_documents){
			$dispatch_documentsHtml .=$dispatch_documents.',';	
		}	
		$dispatch_documentsHtml = substr_replace($dispatch_documentsHtml ,"", -1);
	}	
	$html = '<table cellspacing="0" cellpadding="1" border="1"> 
				<tr>        
					<td rowspan="4">'.$accountData->name.'</td> 
					<td><b>Proforma Id:</b></td>
					  <td>'.$dataPdf->id.'</td>
				</tr>    
				<tr>	
					<td><b>Order Date:</b></td>	
					<td>'.$dataPdf->order_date.'</td>  
				</tr>  
				<tr>      
					<td><b>Payment Terms</b></td> 
					<th>'.$dataPdf->payment_terms.'</th>  
				</tr>
				<tr>      
					<td><b>Dispatch Date</b></td> 
					<th>'.$dataPdf->dispatch_date.'</th>  
				</tr>
				<tr>  
					<td rowspan="20"><b>Customer Name:</b>'.$accountData->name.'</td> 
					<td colspan="2" rowspan="20"><b>GSTIN:</b><br>'.$accountData->gstin.'</td>  
				</tr>
				<tr>  
					<td rowspan="2"><b>Address:</b>'.$accountData->billing_street.'</td> 
					
				</tr>
			</table>';
			$pdf->writeHTML($html, true, false, false, false, '');
			$pdf->Cell(12,5,'SI.no',1,0,'LR',0,2);
			$pdf->Cell(20,5,'UOM',1,0,'L',0,2);
			$pdf->Cell(60,5,'Description of goods',1,0,'L',0,2);
			$pdf->Cell(22,5,'Quantity',1,0,'L',0,2);
			$pdf->Cell(25,5,'Price/per',1,0,'L',0,2);
			$pdf->Cell(10,5,'GST',1,0,'L',0,2);   
			$pdf->Cell(15,5,'Total',1,0,'L',0,2);   
			$pdf->Cell(25,5,'Grand Total',1,0,'L',0,2);   
			$pdf->Ln();
			$no=1;	
			
			$products =  json_decode($dataPdf->product);
			foreach($products as $product){	
				$material_id = $product->product;	
				$materialName = getNameById('material',$material_id,'id');	
				
				$matName = $materialName->material_name;				
				$pdf->Cell(12,10,$no++,1,0,'LR',0,2);
				//$pdf->Cell(60,10,$matName,1,0,'L',0,2);
				$pdf->Cell(20,10,$product->uom,1,0,'L',0,2);
				$pdf->Cell(60,10,$matName,1,0,'L',0,2);
				$pdf->Cell(22,10,$product->quantity,1,0,'L',0,2);
				$pdf->Cell(25,10,$product->price,1,0,'L',0,2);
				$pdf->Cell(10,10,$product->gst,1,0,'L',0,2); 
				$pdf->Cell(15,10,$product->individualTotal,1,0,'L',0,2); 
				$pdf->Cell(25,10,$product->individualTotalWithGst,1,0,'L',0,2); 
				$pdf->Ln();			
			}	    
			$pdf->Ln(10);			
			$pdf->MultiCell(90,50,'Total Amount:'.$dataPdf->total,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,"Grand Total Amount:".$dataPdf->grandTotal,'LBRT','R',0,0);
			$pdf->Ln(10);	
			$pdf->MultiCell(90,50,'AGT Tax:'.$dataPdf->agt,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,"Freight:".$dataPdf->freight,'LBRT','R',0,0);
			$pdf->Ln(10);			
			$pdf->MultiCell(90,50,'Discount Offered:'.$discount_offeredHtml ,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,"Label Printing Express:".$dataPdf->label_printing_express,'LBRT','R',0,0);
			$pdf->Ln(10);			
			$pdf->MultiCell(90,50,'Brand:'.$dataPdf->brand_label,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,"Product Application:".$dataPdf->product_application,'LBRT','R',0,0);
			$pdf->Ln(10);
			$pdf->MultiCell(90,50,'Company PAN:'.$company_data->company_pan,'LBRT','LR',0,0);
			//$pdf->MultiCell(100,50,"For Azuka Synthetic LLP\n\n\n Signature",'LBRT','R',0,0);
			$pdf->Ln(10);
			$pdf->MultiCell(90,50,'Documents Dispatched:'.$dispatch_documentsHtml ,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,"Product Application:".$dataPdf->product_application,'LBRT','R',0,0);
			$pdf->Ln(10);
			
			$pdf->MultiCell(90,50,'Account Name:'.$accountData->name ,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,'Contact Name:'.$contactData->first_name ,'LBRT','R',0,0);
			
			$pdf->Ln(10);
			
			$pdf->MultiCell(90,50,"Customer Address:".$accountData->billing_street,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,"Contact Address:".$contactData->mailing_street,'LBRT','R',0,0);
			$pdf->Ln(10);
			
			$pdf->MultiCell(90,50,"Customer Email:".$accountData->email,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,"Contact Email:".$contactData->email,'LBRT','R',0,0);
			$pdf->Ln(10);
			
			$pdf->MultiCell(90,50,"Customer Phone:".$accountData->phone,'LBRT','LR',0,0);
			$pdf->MultiCell(100,50,"Contact Phone:".$contactData->phone,'LBRT','R',0,0);
			$pdf->Ln(10);
			
?>