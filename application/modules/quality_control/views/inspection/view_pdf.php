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
	$machineName = $processName = $workOrder = "";
	foreach($get_workorder as $work){
        if( isset($edit->workorder_id) ) {
            if($work['id'] == $edit->workorder_id ) { $workOrder =  $work['work_order_no']; }
        }
	}
    
    if(!empty($edit->process_id)){
        $proc_nam = getNameById('add_process', $edit->process_id,'id');
    if(!empty($proc_nam)){$processName = $proc_nam->process_name;}
        
    }
    
    if(!empty($edit->machine_id)){
        $proc_nam = getNameById('add_machine', $edit->machine_id,'id');
        if(!empty($proc_nam)){$machineName = $proc_nam->machine_name;}
        
    }
    
	 
      $border = 'border="1"';
      $cellpaddingReport = 'cellpadding="2"';
      $col2 = 'colspan="2"';
	    $content .= '<table>
            			<tr>
            				<td  align="center"><img src="'.$companyLogo.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
            			</tr>
            			<tr>
            				<td colspan="1"><div style="margin-top: 15%;"><h2 align="center">Manifacture Report</h2></div></td>
            			</tr>
            		</table>';
		$createdDate = date('d-m-Y',strtotime($edit->created_date));
        $created_by = ($edit->created_by!=0)?(getNameById('user_detail',$edit->created_by,'u_id')->name):'';
	    $content .= "<table {$border} {$cellpaddingReport}>
                   <tr>
                      <td><strong>Report Name  :</strong>{$edit->report_name}</td>
                      <td><strong>Manufacturing Date  :</strong>{$createdDate}</td>
                      <td><strong>No. of Observation  :</strong>{$edit->observations}</td>
                   </tr>
                   <tr>
                      <td><strong>Inspection date  :</strong>{$createdDate}</td>
                      <td><strong>Per Lot Of Observation  :</strong>{$edit->per_lot_of}</td>
                      <td><strong>Created By  :</strong>{$created_by}</td>
                   </tr>
                   <tr>
                      <td><strong>Work Order  :</strong>{$workOrder}</td>
                      <td><strong>Process :</strong>{$processName}</td>
                      <td><strong>Machine :</strong>{$machineName}</td>
                   </tr>
                </table>";
        $content .= $machineData;
        $content .= $machineParemeter;

        $fr = "";
        if( $edit->final_report == 1 ){
            $fr = "Pass";
        }elseif($edit->final_report == 2){
            $fr = "Fail";
        }

        $content .= '<table>
                  <tr>
                    <td colspan="1"><div style="margin-top: 15%;"><h2 align="center">'.$fr.'</h2></div></td>
                  </tr>
                </table>';
    $obj_pdf->writeHTML($content); 
	    ob_end_clean();	
    $obj_pdf->Output('sample.pdf', 'I');  
