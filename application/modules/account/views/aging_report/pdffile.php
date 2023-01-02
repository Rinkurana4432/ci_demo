<?php 

		//ob_start();
		setlocale(LC_MONETARY, 'en_IN');
		$pdflayout = array('350', '350');
		$obj_pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdflayout, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);  
		$obj_pdf->SetTitle("Ageing Report");  
		$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		$obj_pdf->SetDefaultMonospacedFont('helvetica');  
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		//$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
		$obj_pdf->SetMargins(5, 20, 5, true);	
		$obj_pdf->setPrintHeader(false);  
		$obj_pdf->setPrintFooter(true);  
		$obj_pdf->SetAutoPageBreak(TRUE, 10);  
		$obj_pdf->SetFont('helvetica', '', 12);
		$image = FCPATH .'assets/images/logo.png';
		
		
		
		
		
		
		$obj_pdf->AddPage();
		
		$content = '';
		$content .= '<style> table{width:100%; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;}
		.aging { width: 25%;vertical-align: top;}.aging td {border: 0px;}.aging tr p{margin-bottom: 1px !important;}</style>';
		
		
		$content .= '<table>
				
					<tr>
						<td colspan="1"><img src="'.$image.'" alt="test alt attribute" width="60" height="50" border="0" ></td>
						<td colspan="10"><div><h4 align="center">Ageing Report</h4></div></td>
					</tr>
			</table>
			<table class="header-section" border="1" style="border-spacing: 0; border-collapse: collapse;" cellspacing="0" cellpadding="5">';	
						   
						   
				$content .= '<tr>
								<td>Id</td>
								<td>Invoice Date</td>
								<td>Invoice</td>
								<td>Party Name</td>
								<td>Sales Person</td>
								<td>Invoice Amount</td>
								<td>Due Date</td>
								<td>Days Over Due</td>
							</tr>';		   
						   if(!empty($add_invoice_details)){
										$total_amount_sum = 0;
										foreach($add_invoice_details as $aging_Rpt_val){
											
										
											$total_amount_sum += $aging_Rpt_val['total_amount'];
											if($aging_Rpt_val['due_date'] != 0){
												$current_Date = date ("Y-m-d");
												$due_date = date("Y-m-d", strtotime($aging_Rpt_val['due_date']));
												$start = strtotime($current_Date);
												$end = strtotime($due_date);
												//$days_between = ceil(abs($end - $start) / 86400);
												$above_days_between = ($start - $end)/60/60/24; 
												$dueDate = date("d - M - Y", strtotime($aging_Rpt_val['due_date']));
											}else{
												$above_days_between = 'Day not Set';
												$dueDate =  '0000-00-00';
											}
											$party_name = getNameById('ledger',$aging_Rpt_val['party_name'],'id');
																					
											$sales_person = getNameById('user_detail',$aging_Rpt_val['sales_person'],'u_id');
											
											
										
										
									
										$content .= '<tr><td>'.$aging_Rpt_val['id'].'</td>';
										$content .= '<td>'.date("d - M - Y", strtotime($aging_Rpt_val['date_time_of_invoice_issue'])).'</td>';
										$content .= '<td>'.$aging_Rpt_val['invoice_num'].'</td>';
										$content .= '<td>'.$party_name->name.'</td>';
										$content .= '<td>'.$sales_person->name.'</td>';
										$content .= '<td>'.money_format('%!i',$aging_Rpt_val['total_amount']).'</td>';
										$content .= '<td>'.$dueDate.'</td>';
										$content .= '<td>'.$above_days_between.'</td></tr>';
										
									}
									
										$content .= '<tr><td colspan="5" align="right"><b>Total :- </b></td><td>'.money_format('%!i',$total_amount_sum).'</td><td></td><td></td></tr></table>';
										
									
									 
								}
		
					
					 $obj_pdf->writeHTML($content); 
					
					ob_end_clean();
					// pre($content);
// die(); 
					$obj_pdf->Output('Report.pdf', 'I'); 