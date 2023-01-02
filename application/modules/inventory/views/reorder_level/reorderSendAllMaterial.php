<?php   	
   /* $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
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
    $obj_pdf->SetFont('helvetica', '', 11);*/

	$company_data = getNameById('company_detail',$companyId,'id');
	$image = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	/*$obj_pdf->Image($image,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage();*/
	$content = '
	<table>
		<tr>
			<td align="center"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td></tr>
			<tr>
			<td colspan="6"><div style="margin-top: 20%;"><h2 align="center">Reorder Level Report</h2></div></td>
		</tr>
	</table>
	<table border="1" cellpadding="2">
		<tr>
			<td colspan="7"><strong>Report Date.</strong> &nbsp; '.date("j F , Y").'</td>
		</tr>		
		<tr>
			<th ><strong>Type</strong></th>
			<th ><strong>Product Code</strong></th>
			<th ><strong>Sub-Type</strong></th>
			<th ><strong>Product Name</strong></th>
			<th ><strong>Clossing Balance</strong></th>
			<th ><strong>UOM</strong></th>
			<th ><strong>Reorder quantity</strong></th>
		</tr>';	 
	     if( $recorderData ){
	        foreach ($recorderData as $key => $value) {
	           $rowSpan = count($value);
	           $i = 1;
	           foreach ($value as $materialKey => $materialValue) {
	              $content .= "<tr>";
                  if( $i == 1 ){ 
                    $content .= '<td rowspan="'.$rowSpan.'" >'.$materialValue['material_type'].'</td>';
                  }
	                $content .= "<td>{$materialValue['material_code']}</td>";
	                $content .= "<td>{$materialValue['sub_type']}</td>";
	                $content .= "<td>{$materialValue['material_name']}</td>";
	                $content .= "<td>{$materialValue['closing_balance']}</td>";
	                $content .= "<td>{$materialValue['uom']}</td>";
	                $content .= "<td>{$materialValue['min_inventory']}</td>";
	                //$content .= "<td></td>";
	              $content .= "</tr>";
	           		$i++; 
	       		}
	        }
	     }

	$content .= '</table>';  
	echo $content;
	/*ob_end_clean();
	$obj_pdf->writeHTML($content);  
	
	$obj_pdf->Output('Reorder_Inventory.pdf', 'F');  */
 ?>  
