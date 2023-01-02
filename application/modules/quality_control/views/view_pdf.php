<?php    
    
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("Manifacture Report");  
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
	$company_data = getNameById('company_detail',$edit->created_by_cid,'id');
	//$get_company_unit = json_decode($company_data->address,true);
	//foreach($get_company_unit as $get_comp_gst){
	//	if($get_comp_gst['add_id'] == $dataPdf->company_unit){
	//		$company_GSTNO = $get_comp_gst['company_gstin'];
	//	}
	//}
	$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	
	$obj_pdf->Image($companyLogo,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
						
    //$supplierName=getNameById('supplier',$dataPdf->supplier_name,'id');	
    //$state= getNameById('state',$supplierName->state,'state_id');
    $obj_pdf->AddPage(); 
    $content = ''; 
	#echo $companyLogo; die;
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	//$brnch_name = getNameById_with_cid('company_address', $dataPdf->delivery_address, 'id','created_by_cid',$this->companyGroupId);

	 
      $border = 'border="1"';
      $cellpaddingReport = 'cellpadding="2"';
      $col2 = 'colspan="2"';
	    $content .= '<table >
            			<tr>
            				<td  align="center"><img src="'.$companyLogo.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
            			</tr>
            			<tr>
            				<td colspan="1"><div style="margin-top: 15%;"><h2 align="center">Manifacture Report</h2></div></td>
            			</tr>
            		</table>';
      $typeName = $mName = $uom = "";
      $md = date('d-M-Y',strtotime($edit->created_date));
        foreach($uom as $data){
            if($data->id==$edit->uom){ $uom = $data->uom_quantity; }
        }
        foreach($material as $material_name){ 
            if($edit->material_id==$material_name['id']){$mName = $material_name['material_name'];}
        }
        if( $edit->saleorder == 'grn' ){
            $typeName = "GRN";
        }elseif($edit->saleorder == 'pid') {
            $typeName = "PDI";
        }
      $content .= "<table {$border} {$cellpaddingReport}>
                  <tr>
                    <td>Report Name :  {$edit->report_name}</td>
                    <td>Manufacturing Date :  {$md}</td>
                    <td>No. of Observation :  {$edit->observations}</td>
                  </tr>
                  <tr>
                     <td>Per Lot Of Observation : {$edit->per_lot_of}</td>
                     <td>UOM : {$uom}</td>
                     <td>{$typeName} : {$mName}</td>
                  </tr>
                </table><br><br><br>";
        $content .= '<table border="1" cellpadding="3">
            <thead>
               <tr>              
                  <th>Sno.</th>
                  <th>Parameters</th>
                  <th>Instrument</th>
                  <th>Uom</th>
                  <th>Expectation</th>
                  <th>Deviation minimum</th>
                  <th>Deviation maximum</th>
                  <th>Expectation with minimum Deviation</th>
                  <th>Expectation with maximum Deviation</th>
                  <th>Result</th>
                  <th>Remark</th>'; 
                  if( $edit->observations ){ 
                        for ($i=1; $i <= $edit->observations ; $i++) {
                          $content .= "<th>Obs{$i}</th>";
                         }
                  }
               $content .= "<th>Avg</th>
                              <th>Pass/Fail</th>
                           </tr>
          </thead>";
          $content .= '<tbody id="table_data">';
                       $i = 1;
                      foreach($trans as $key => $val){
                          $content .= "<tr>";
                          $content .= "<td>{$i}</td>";     
                          $content .= "<td>{$val->parameter}</td>";     
                          $content .= "<td>";
                                      foreach($ins as $value){
                                           if($value['id']==$val->instrument){ $content .= $value['name']; }
                                        }
                          $content .= "</td>";
                          $content .= "<td>";
                                      foreach($uom as $umoVal){
                                           if($umoVal->id==$val->uom1){ $content .= $umoVal->uom_quantity; }
                                        }
                          $content .= "</td>";

                         $content .= "<td>{$val->expectation}</td>";
                         $content .= "<td>{$val->deviation_min}</td>";
                         $content .= "<td>{$val->deviation_max}</td>";
                         $content .= "<td>{$val->exp_min_dev}</td>";
                         $content .= "<td>{$val->exp_max_dev}</td>";
                         $content .= "<td>{$val->result}</td>";
                         $content .= "<td>{$val->remark}</td>";
                         if( isset($val->coils) ){
                            $obs = json_decode($val->coils);
                          }

                          if( $edit->observations ){ 
                              for ($j=1; $j <= $edit->observations ; $j++) {
                                    $content .= "<td>";
                                      $obsSr = "obs_{$j}";
                                      $content .= $obs->$obsSr;
                                    $content .= "</td>";
                               }
                          }
                          $content .= "<td>{$val->avg}</td>";
                          $content .= "<td>";
                          if( isset($val->pf) ){
                            $content .= $val->pf;
                          }
                          $content .= "</td>";
                          $content .= "</tr>";
                          $i++;
                      }
          $content .= '</tbody>';
          $content .= "</table><br><br><br>";
          $content .= '<table border="1" cellpadding="3">';
          if($edit->final_report=='1'){$content .= '<tr><td style="text-align:center;">Pass</td></tr>';} 
          if($edit->final_report=='2'){$content .= '<tr><td style="text-align:center;">Fail</td></tr>';}
          $content .= "</table>";

    $obj_pdf->writeHTML($content); 
	    ob_end_clean();	
    $obj_pdf->Output('sample.pdf', 'I');  
