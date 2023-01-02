<?php   	
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("Reorder Level Report");  
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);   
    $obj_pdf->SetAutoPageBreak(TRUE);  
    $obj_pdf->SetFont('helvetica', '', 11);

	$company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');

	$bank_info = json_decode($company_data->bank_details);
    $primarybnk  = $bank_info[0];
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	$obj_pdf->Image($image,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage(); 	
    $content = ''; 
    $products =  json_decode($dataPdf->inventory_items);
    #pre($products);
   # die;
    $createdby = ($dataPdf->created_by!=0)?(getNameById('user_detail',$dataPdf->created_by,'u_id')->name):'';
#!empty($primaryContact)?$primaryContact->phone_no:''
	$content .= '
	<table>
		<tr>
			<td align="center"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td></tr>
			<tr>
			<td colspan="8"><div style="margin-top: 20%;"><h2 align="center">Reorder Level Report</h2></div></td>
		</tr>
	</table>
	<table border="1" cellpadding="2">
		<tr>
			<td colspan="3"><strong>Created By.</strong> &nbsp; '.$createdby.'</td>
			<td colspan="3"><strong>Report Date.</strong> &nbsp; '.date("j F , Y", strtotime($dataPdf->report_date)).'</td>
		</tr>		
		<tr>
			<th width="30px"><strong>S No.</strong></th>
			<th width="100px"><strong>Product Code</strong></th>
			<th width="60px"><strong>Type</strong></th>
			<th width="60px"><strong>Sub-Type</strong></th>
			<th width ="120"><strong>Product Name</strong></th>
			<th width="60px"><strong>Clossing Balance</strong></th>
			<th width="30px"><strong>UOM</strong></th>
			<th width="50px"><strong>Reorder quantity</strong></th>
			
		</tr>

		';
		$i = 0;
		foreach($products as $product){

		  pre($product);
		// die;

			$i++;
			$materialType = getNameByID('material_type',$product->type,'id');	
			// $locationName = getNameById('company_address', $product->location_id, 'id');			
			$mattype_name = !empty($materialType)?$materialType->name:'';
			$ww =  getNameById('uom', $product->uom,'id');
			$uom = !empty($ww)?$ww->ugc_code:'N/A';
			$pro_type = !empty($product->sub_type)?$product->sub_type:'N/A';
														
			$content .= '<tr>
				<td>'.$i.'</td>
				<td><h5>'.$product->product_code.'</h5></td>
				<td>'.$mattype_name.'</td>
				<td>'.$pro_type.'</td>
				<td>'.$product->product_name.'</td>
				<td>'.$product->clossing_balance.'</td>
				<td>'.$uom.'</td>
				<td>'.$product->reorder_quantity.'</td>
			</tr>';
			}			
	$content .= '</table>';  
	ob_end_clean();
	$obj_pdf->writeHTML($content);  
	
	$obj_pdf->Output('Reorder_Inventory.pdf', 'I');  
 ?>  
