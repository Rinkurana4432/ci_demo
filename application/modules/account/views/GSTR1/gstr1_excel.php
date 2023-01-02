<?php
 //ob_end_clean(); 

$filename = "gstr1" . ".xls"; 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

?>
<div class="x_content">


	<?php 
	$company_brnaches = getNameById('company_detail',$_SESSION['loggedInUser']->c_id,'id');
	?>
	
<div class="settin-tab" role="tabpanel" data-example-id="togglable-tabs">
	 <!--<h3 class="Material-head">Information<hr></h3>-->
	<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
		<li role="presentation" class="firstt active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Information</a>
		</li>
		<li role="presentation" class="secc "><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Help Instructions</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">b2b</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content4" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">b2cl</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content5" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">b2cs</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content6" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">cdnr</a></li>
		
		<li role="presentation" class="secc "><a href="#tab_content7" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">cdnur</a></li>
		<li role="presentation" class="secc "><a href="#tab_content8" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">exp</a></li>
		<li role="presentation" class="secc "><a href="#tab_content9" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">at</a></li>
		<li role="presentation" class="secc "><a href="#tab_content10" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">atadj</a></li>
		<li role="presentation" class="secc "><a href="#tab_content11" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">exemp</a></li>
		<li role="presentation" class="secc "><a href="#tab_content12" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">hsn</a></li>
		<li role="presentation" class="secc "><a href="#tab_content13" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">docs</a></li>
</ul>
	<div id="myTabContent" class="tab-content list-vies-2" style="clear: both;">
	 <div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12 tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab" style="clear: both;"> 		
	<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>SNo.</th>
				<th>Particulars</th>
				<th>Voucher count</th>
				<th>Taxable value</th>
				<th>Integrated Tax Amount</th>
				<th>Central Tax Amount</th>
				<th>State Tax Amount</th>
				<th>Cess Amount</th>
				<th>Tax Amount</th>
				<th>Invoice Amount</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
		<?php
		setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
		//pre($invoice_data);
		//pre($GSTR1_data);
		$first_b2b=0;
		$gstn_count = 0;
		$gstn_count_blank = 0;
		$sec_b2c=0;
		$total_amount=0;
		
		$integrated_tax_sum= 0;
		$cgst_and_sgst_sum= 0;
		$third_b2c_small = 0;
		$divide_cgst_sgst= 0;
		$total_amount_blank= 0;
		$integrated_tax_sum_blank= 0;
		$cgst_and_sgst_sum_blank= 0;
		
			$gstn_count_blank_third=0;
			$total_amount_blank_third=0;
			$integrated_tax_sum_blank_third= 0;
			$cgst_and_sgst_sum_blank_third= 0;
			$fifth_export_invoices_6A=0;
			$integrated_tax_sum_export_invoice=0;
			$gstn_count_blank_export_invoice=0;
			$total_amount_witout_tax1=0;
			$total_amount_blank_export_invoice=0;
			$tax_amount_total_export_invoice=0;
			$cgst_and_sgst_sum_export_invoice=0;
			
			$sixth_tax_liability_advnce_recive=0;
			$gstn_count_blank_advance = 0;
			$total_amount_blank_advance = 0;
			$integrated_tax_sum_advance = 0;
			$cgst_and_sgst_sum_advance = 0;
			$tax_amount_total_advance = 0;
			$invoice_amount_total_advanec = 0;
			
			$nill_rated_invoice = 0;
			$gstn_count_with_zero_tax = 0;
			$total_amount_with_zero_tax = 0;
		$ddte = 0;
				 foreach($invoice_data as $invoce_cal){
					
					
					$total_amount_witout_tax_Amount = json_decode($invoce_cal['invoice_total_with_tax']);
					$total_amount_for_conditions = $total_amount_witout_tax_Amount[0]->total;
					if($invoce_cal['gstin'] !='' && $invoce_cal['invoice_type']=='domestic_invoice'){
						 $gstn_count+= count($invoce_cal['gstin']);
						
							/* Total Amount without Tax Calulate*/
								$total_amount_witout_tax = json_decode($invoce_cal['invoice_total_with_tax']);
								$total_amount = $total_amount + $total_amount_witout_tax[0]->total;
								
						 	/* Total Amount without Tax Calulate*/
							
							/*Integrated Tax Amount*/
								
								
								$company_state_id = $invoce_cal['sale_L_state_id'];
								if($company_state_id != $invoce_cal['party_state_id'] ){//When company and ledger are not same 
									$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);
									$integrated_tax_sum = $integrated_tax_sum + $total_tax[0]->totaltax;
								}
								
								if($company_state_id == $invoce_cal['party_state_id'] ){//When company and ledger are same 
									$total_tax2 = json_decode($invoce_cal['invoice_total_with_tax']);
									$cgst_and_sgst_sum = $cgst_and_sgst_sum + $total_tax2[0]->totaltax;
									$divide_cgst_sgst = $cgst_and_sgst_sum / 2;
									
								}
						/*Integrated Tax Amount*/
						
						/* Calculate Tax Amount*/
							$tax_amount_total = $integrated_tax_sum + $cgst_and_sgst_sum;
						/* Calculate Tax Amount*/
						/*Invoice Amount*/
						    $invoice_amount_total_with_tax = $tax_amount_total + $total_amount;
						/*Invoice Amount*/
							$first_b2b = array('count'=>$gstn_count,'taxable_value'=>$total_amount,'integrated_tax'=>$integrated_tax_sum,'central_amount_tax'=>$divide_cgst_sgst,'state_amount_tax'=>$divide_cgst_sgst,'cess_amount'=>'','tax_amount'=>$tax_amount_total,'invoice_amount'=>$invoice_amount_total_with_tax);
							
							
			}else if($invoce_cal['gstin'] =='' && $total_amount_for_conditions > 500 && $invoce_cal['invoice_type']=='domestic_invoice' ){
							$gstn_count_blank+= count($invoce_cal['gstin']);
							$total_amount_witout_tax = json_decode($invoce_cal['invoice_total_with_tax']);
							$total_amount_blank+= $total_amount_blank + $total_amount_witout_tax[0]->total;
						   /*Integrated Tax Amount*/
							
							
							$company_state_id = $invoce_cal['sale_L_state_id'];
							if($company_state_id != $invoce_cal['party_state_id'] ){
								$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);	
							    $integrated_tax_sum_blank = $integrated_tax_sum_blank + $total_tax[0]->totaltax;
							}
							if($company_state_id == $invoce_cal['party_state_id']){
								$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);	
								$cgst_and_sgst_sum_blank = $cgst_and_sgst_sum_blank + $total_tax[0]->totaltax / 2;
								
							}
							/*Integrated Tax Amount*/
							
							/* Calculate Tax Amount*/
								$tax_amount_total = $integrated_tax_sum_blank + $cgst_and_sgst_sum_blank;
							/* Calculate Tax Amount*/
							/*Invoice Amount*/
								$invoice_amount_total_with_tax = $tax_amount_total + $total_amount_blank;
							/*Invoice Amount*/
								$sec_b2c = array('count'=>$gstn_count_blank,'taxable_value'=>$total_amount_blank,'integrated_tax'=>$integrated_tax_sum_blank,'central_amount_tax'=>$cgst_and_sgst_sum_blank,'state_amount_tax'=>$cgst_and_sgst_sum_blank,'cess_amount'=>'','tax_amount'=>$tax_amount_total,'invoice_amount'=>$invoice_amount_total_with_tax);
								
								
			}
			
			
			
			if($invoce_cal['gstin'] =='' && $total_amount_for_conditions < 500 && $invoce_cal['invoice_type']=='domestic_invoice'){
							$gstn_count_blank_third+= count($invoce_cal['gstin']);
							$total_amount_witout_tax1 = json_decode($invoce_cal['invoice_total_with_tax']);
							$total_amount_blank_third += $total_amount_witout_tax1[0]->total;
							
						
						   /*Integrated Tax Amount*/
							
							$company_state_id = $invoce_cal['sale_L_state_id'];
							if($company_state_id != $invoce_cal['party_state_id'] ){
								$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);	
							    $integrated_tax_sum_blank_third = $integrated_tax_sum_blank_third + $total_tax[0]->totaltax;
							}
							if($company_state_id == $invoce_cal['party_state_id'] ){
								$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);	
								$cgst_and_sgst_sum_blank_third = $cgst_and_sgst_sum_blank_third + $total_tax[0]->totaltax / 2;
								
							}
							/*Integrated Tax Amount*/
							
							/* Calculate Tax Amount*/
								$tax_amount_total_third = $integrated_tax_sum_blank_third + $cgst_and_sgst_sum_blank_third;
							/* Calculate Tax Amount*/
							/*Invoice Amount*/
								$invoice_amount_total_with_tax1 = $tax_amount_total_third + $total_amount_blank_third;
							/*Invoice Amount*/
								$third_b2c_small = array('count'=>$gstn_count_blank_third,'taxable_value'=>$total_amount_blank_third,'integrated_tax'=>$integrated_tax_sum_blank_third,'central_amount_tax'=>$cgst_and_sgst_sum_blank_third,'state_amount_tax'=>$cgst_and_sgst_sum_blank_third,'cess_amount'=>'','tax_amount'=>$tax_amount_total_third,'invoice_amount'=>$invoice_amount_total_with_tax1);	
			}
			
			if($invoce_cal['gstin'] =='' && $invoce_cal['invoice_type']=='export_invoice'){
				
							$gstn_count_blank_export_invoice+= count($invoce_cal['gstin']);
							$total_amount_witout_tax1 = json_decode($invoce_cal['invoice_total_with_tax']);
							$total_amount_blank_export_invoice += $total_amount_witout_tax1[0]->total;
							
						
						   /*Integrated Tax Amount*/
							
							$company_state_id = $invoce_cal['sale_L_state_id'];
							if($company_state_id != $invoce_cal['party_state_id'] ){
								$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);	
							    $integrated_tax_sum_export_invoice = $integrated_tax_sum_export_invoice + $total_tax[0]->totaltax;
							}
							if($company_state_id == $invoce_cal['party_state_id'] ){
								$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);	
								$cgst_and_sgst_sum_export_invoice = $cgst_and_sgst_sum_export_invoice + $total_tax[0]->totaltax / 2;
								
							}
							/*Integrated Tax Amount*/
							
							/* Calculate Tax Amount*/
								$tax_amount_total_export_invoice = $integrated_tax_sum_export_invoice + $cgst_and_sgst_sum_export_invoice;
							/* Calculate Tax Amount*/
							/*Invoice Amount*/
								$invoice_amount_total_with_export_invoice = $tax_amount_total_export_invoice + $total_amount_blank_export_invoice;
							/*Invoice Amount*/
							
							$fifth_export_invoices_6A = array('count'=>$gstn_count_blank_export_invoice,'taxable_value'=>$total_amount_blank_export_invoice,'integrated_tax'=>$integrated_tax_sum_export_invoice,'central_amount_tax'=>$cgst_and_sgst_sum_export_invoice,'state_amount_tax'=>$cgst_and_sgst_sum_export_invoice,'cess_amount'=>'','tax_amount'=>$tax_amount_total_export_invoice,'invoice_amount'=>$invoice_amount_total_with_export_invoice);
				
				
			}
			
			if($invoce_cal['mode_of_payment'] =='advance'){
				$gstn_count_blank_advance+= count($invoce_cal['gstin']);
				$total_amount_witout_tax1 = json_decode($invoce_cal['invoice_total_with_tax']);
				$total_amount_blank_advance += $total_amount_witout_tax1[0]->total;
					
				
				   /*Integrated Tax Amount*/
					
					$company_state_id = $invoce_cal['sale_L_state_id'];
					if($company_state_id != $invoce_cal['party_state_id'] ){
						$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);	
						$integrated_tax_sum_advance = $integrated_tax_sum_advance + $total_tax[0]->totaltax;
					}
					if($company_state_id == $invoce_cal['party_state_id'] ){
						$total_tax = json_decode($invoce_cal['invoice_total_with_tax']);	
						$cgst_and_sgst_sum_advance = $cgst_and_sgst_sum_advance + $total_tax[0]->totaltax / 2;
						
					}
					/*Integrated Tax Amount*/
					
					/* Calculate Tax Amount*/
						$tax_amount_total_advance = $integrated_tax_sum_advance + $cgst_and_sgst_sum_advance;
					/* Calculate Tax Amount*/
					/*Invoice Amount*/
						$invoice_amount_total_advanec = $tax_amount_total_advance + $total_amount_blank_advance;
					/*Invoice Amount*/
					
					$sixth_tax_liability_advnce_recive = array('count'=>$gstn_count_blank_advance,'taxable_value'=>$total_amount_blank_advance,'integrated_tax'=>$integrated_tax_sum_advance,'central_amount_tax'=>$cgst_and_sgst_sum_advance,'state_amount_tax'=>$cgst_and_sgst_sum_advance,'cess_amount'=>'','tax_amount'=>$tax_amount_total_advance,'invoice_amount'=>$invoice_amount_total_advanec);
				
			}
			
			if($total_amount_witout_tax_Amount[0]->totaltax == 0){//when tax is equal to 0
					$gstn_count_with_zero_tax+= count($invoce_cal['gstin']);
					$total_amount_witout_tax1 = json_decode($invoce_cal['invoice_total_with_tax']);
				
					$total_amount_with_zero_tax = $total_amount_with_zero_tax + $total_amount_witout_tax1[0]->total;
				$nill_rated_invoice = array('count'=>$gstn_count_with_zero_tax,'taxable_value'=>$total_amount_with_zero_tax,'integrated_tax'=>'0','central_amount_tax'=>'0','state_amount_tax'=>'0','cess_amount'=>'','tax_amount'=>'0','invoice_amount'=> $total_amount_with_zero_tax);
			}

 
			
			
}
$current_login_id = $_SESSION['loggedInUser']->c_id;

	$voucher_type_data = Get_Voucher_detail_reg_unreg('transaction_dtl',$current_login_id);
	$taxable_value = $debit_dtl = $credit_dtl = 0;      
	$integrated_tax_ttl = $debit_tax = $credit_tax = 0;      
	$central_tax_ttl = $debit_tax_cent = $credit_tax_cent = 0;      
	$state_tax_ttl = $debit_tax_state = $credit_tax_state = 0;      
	$all_tax_ttl = $all_debit_tax = $all_credit_tax = 0; 
	$voucher_without_gst = 0;

	
	$taxable_value1 = $debit_dtl1 = $credit_dtl1 = 0;      
	$integrated_tax_ttl1 = $debit_tax1 = $credit_tax1 = 0;      
	$central_tax_ttl1 = $debit_tax_cent1 = $credit_tax_cent1 = 0;      
	$state_tax_ttl1 = $debit_tax_state1 = $credit_tax_state1 = 0;      
	$all_tax_ttl1 = $all_debit_tax1 = $all_credit_tax1 = 0;
    $voucher_without_gst1 = 0;
   $ddte = $invoce_cal['created_date'];	
					foreach($credit_debit_notes as $voucher_Data){
						
						$cr_dr_data = json_decode($voucher_Data['credit_debit_party_dtl'],true);
						foreach($cr_dr_data as $data_voucher){
						if($data_voucher['cr_dr'] == 'debit'){
							// $ladger_dtl = getNameById('ledger',$data_voucher['credit_debit_party_dtl'],'id');
						
							if($voucher_Data['party_gst'] != ''){
								$voucher_without_gst += count($voucher_Data['party_gst']);
								$debit_dtl += $data_voucher['debit_1'];
								$credit_dtl += $data_voucher['credit_1'];
								$taxable_value =  $debit_dtl + $credit_dtl; 
								
								if($data_voucher['credit_debit_party_dtl'] == 1){
									
									$debit_tax += $data_voucher['debit_1'];
									$credit_tax += $data_voucher['credit_1'];
									$integrated_tax_ttl =  $debit_tax + $credit_tax; 
					
								}
								if($data_voucher['credit_debit_party_dtl'] == 2){
									$debit_tax_cent += $data_voucher['debit_1'];
									$credit_tax_cent += $data_voucher['credit_1'];
									$central_tax_ttl =  $debit_tax_cent + $credit_tax_cent; 
								}
								if( $data_voucher['credit_debit_party_dtl'] == 3){
									$debit_tax_state += $data_voucher['debit_1'];
									$credit_tax_state += $data_voucher['credit_dtl'];
									$state_tax_ttl =  $debit_tax_state + $credit_tax_state; 
								}
								if($data_voucher['credit_debit_party_dtl'] == 1 || $data_voucher['credit_debit_party_dtl'] == 2 || $data_voucher['credit_debit_party_dtl'] == 3 ){
									$all_debit_tax += $data_voucher['debit_1'];
									$all_credit_tax += $data_voucher['credit_1'];
									$all_tax_ttl =  $all_debit_tax + $all_credit_tax;    
								}
								
								
								$fourth_credit_debit_notes_registerd = array('count'=>$voucher_without_gst,'taxable_value'=>$taxable_value,'integrated_tax'=>$integrated_tax_ttl,'central_amount_tax'=>$central_tax_ttl,'state_amount_tax'=>$state_tax_ttl,'cess_amount'=>'','tax_amount'=>$all_tax_ttl,'invoice_amount'=>$taxable_value,'date'=>$ddte);
								
								
							}
					
							if($voucher_Data['party_gst'] == ''){
								
								$voucher_without_gst1 += count($voucher_Data['party_gst']);
								
								$debit_dtl1 += $data_voucher['debit_1'];
								$credit_dtl1 += $data_voucher['credit_1'];
								$taxable_value1 =  $debit_dtl1 + $credit_dtl1;    
								
								if($data_voucher['credit_debit_party_dtl'] == 1){
									$debit_tax1 += $data_voucher['debit_1'];
									$credit_tax1 += $data_voucher['credit_1'];
									$integrated_tax_ttl1 =  $debit_tax1 + $credit_tax1; 
																	
								}
								if($data_voucher['credit_debit_party_dtl'] == 2){
									$debit_tax_cent1 += $data_voucher['debit_1'];
									$credit_tax_cent1 += $data_voucher['credit_1'];
									$central_tax_ttl1 =  $debit_tax_cent1 + $credit_tax_cent1; 
								}
								if( $data_voucher['credit_debit_party_dtl'] == 3){
									$debit_tax_state1 += $data_voucher['debit_1'];
									$credit_tax_state1 += $data_voucher['credit_1'];
									$state_tax_ttl1 =  $debit_tax_state1 + $credit_tax_state1; 
								}
								if($data_voucher['credit_debit_party_dtl'] == 1 || $data_voucher['credit_debit_party_dtl'] == 2 || $data_voucher['credit_debit_party_dtl'] == 3 ){
									$all_debit_tax1 += $data_voucher['debit_1'];
									$all_credit_tax1 += $data_voucher['credit_1'];
									$all_tax_ttl1 =  $all_debit_tax1 + $all_credit_tax1;    
								}
								
								
								
								$fourth_credit_debit_notes_Unregistered = array('count'=>$voucher_without_gst1,'taxable_value'=>$taxable_value1,'integrated_tax'=>$integrated_tax_ttl1,'central_amount_tax'=>$central_tax_ttl1,'state_amount_tax'=>$state_tax_ttl,'cess_amount'=>'','tax_amount'=>$all_tax_ttl1,'invoice_amount'=>$taxable_value1,'date'=>$ddte);
								
							} 
						}
					}		
			}
			
						$eigth_adjustmnet_of_advance = array('count'=>'0','taxable_value'=>'0','integrated_tax'=>'0','central_amount_tax'=>'0','state_amount_tax'=>'0','cess_amount'=>'','tax_amount'=>'0','invoice_amount'=>'0','date'=>$ddte);
			
						$all_invoice_data = array(array('B2B Invoices - 4A,4B,4C' =>$first_b2b,'B2C (Large) Invoice-5A,5B' =>$sec_b2c,'B2C (Small) Invoice- 7'=>$third_b2c_small,'Credit/Debit Notes(Registered)-9B'=>$fourth_credit_debit_notes_registerd,'Credit/Debit Notes(Unregistered)-9B'=>$fourth_credit_debit_notes_Unregistered,'Export Invoices - 6A'=>$fifth_export_invoices_6A,'Tax Liability(Advances recevied)-11A(1),11A(2)'=>$sixth_tax_liability_advnce_recive,'Adjustment of Advances-11B(1),11B(2)'=>$eigth_adjustmnet_of_advance,'Nill Rated Invoices - 8A,8B,8C,8D'=>$nill_rated_invoice,'date'=>$ddte));
						//pre($all_invoice_data);die();
				
						$sno = 1;
						foreach($all_invoice_data as $dd_val){
							// pre($all_invoice_data);
							foreach($GSTR1_data as $gstr1_name){
							  
							//if(array_key_exists($gstr1_name,$all_invoice_data)) {
							echo '<tr><td>'.$sno.'</td><td>'.$gstr1_name.'</td><td>'.$dd_val[$gstr1_name]['count'].'</td><td>'.money_format('%!i',$dd_val[$gstr1_name]['taxable_value']).'</td><td>'.money_format('%!i',$dd_val[$gstr1_name]['integrated_tax']).'</td><td>'.money_format('%!i',$dd_val[$gstr1_name]['central_amount_tax']).'</td><td>'.money_format('%!i',$dd_val[$gstr1_name]['state_amount_tax']).'</td><td>'.$dd_val[$gstr1_name]['cess_amount'].'</td><td>'.money_format('%!i',$dd_val[$gstr1_name]['tax_amount']).'</td><td>'.money_format('%!i',$dd_val[$gstr1_name]['invoice_amount']).'</td><td style="display:none;">'.$ddte.'</td></tr>';
							//}
							
							$count_total += $dd_val[$gstr1_name]['count'];
							$taxable_valu_total += $dd_val[$gstr1_name]['taxable_value'];
							$integrated_tax_valu_total += $dd_val[$gstr1_name]['integrated_tax'];
							$central_amount_tax_valu_total += $dd_val[$gstr1_name]['central_amount_tax'];
							$state_amount_tax_valu_total += $dd_val[$gstr1_name]['state_amount_tax'];
							$cess_amount_tax_valu_total += $dd_val[$gstr1_name]['cess_amount'];
							$tax_amount_tax_valu_total += $dd_val[$gstr1_name]['tax_amount'];
							$invoice_amount_tax_valu_total += $dd_val[$gstr1_name]['invoice_amount'];
							
							
							
							
							$sno++;	
							
							}
							
						}
					
						
					
						echo '<tr style="background:#ddd;">
								<td></td>
								<th>Total</th>
								<th>'.$count_total.'</th>
								<th>'.money_format('%!i',$taxable_valu_total).'</th>
								<th>'.money_format('%!i',$integrated_tax_valu_total).'</th>
								<th>'.money_format('%!i',$central_amount_tax_valu_total).'</th>
								<th>'.money_format('%!i',$state_amount_tax_valu_total).'</th>
								<th>'.money_format('%!i',$cess_amount_tax_valu_total).'</th>
								<th>'.money_format('%!i',$tax_amount_tax_valu_total).'</th>
								<th>'.money_format('%!i',$invoice_amount_tax_valu_total).'</th>
							</tr>';
		?>
		</tbody>                   
	</table>
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content2" aria-labelledby="profile-tab2" style="clear: both;"> 
	<b>Help Instructions</b>
	 <table class="table table-striped table-bordered" border="1" cellpadding="3" style="width:100%">
			    <tr>
					<tr><th>1. The offline tool for generating the JSON file will not take the data available in the sheets exemp and docs.</th></tr>
					<tr><th>2. The values in these sheets are in the same order as in the portal.</th></tr>
					<tr><th>3. You can manually enter the data from these sheets directly into the GSTN portal.</th></tr>
				</tr>
	</table>
	<table class="table table-striped table-bordered" border="1" cellpadding="3" style="width:100%">
			    <tr>
					<tr><th>Visit LERP Help for more information on:</th></tr>
					<tr><th>1. GSTR1 Filing.</th></tr>
					<tr><th>2. Data captured in GSTR1 Return.</th></tr>
				</tr>
	</table>
	<b>Please Note</b>
	 <table class="table table-striped table-bordered" border="1" cellpadding="3" style="width:100%">
			    <tr>
					<tr><th>1. This Excel workbook works best with Microsoft Excel 2003 or later. </th></tr>
					<tr><th>2. We recommend that you do not modify the data in Excel after exporting from Tally.ERP </th></tr>
					<tr><th>3. Use separate Excel workbooks for each month, with the month name as a part of the file name. In case there are multiple uploads for a month, use Part A, Part B, and so on, in the file name to avoid confusion. Similarly, if you import invoice data multiple times in a tax period, follow a similar pattern for the JSON file name.</th></tr>
					<tr><th>4. If any data exists in the offline tool when you are importing data from Excel, all the existing data will be overwritten.</th></tr>
				</tr>
	</table>		
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content3" aria-labelledby="profile-tab2" style="clear: both;"> 
	<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>GSTIN/UIN of Recipient</th>
				<th>Invoice Number</th>
				<th>Invoice date</th>
				<th>Invoice Value</th>
				<th>Place Of Supply</th>
				<th>Reverse Charge</th>
				<th>Applicable % of Tax Rate</th>
				<th>Invoice Type</th>
				<th>E-Commerce GSTIN</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($invoice_data as $b2b_data){
					if($b2b_data['gstin'] !=''){
						$total_value = $b2b_data['total_amount'] -  $b2b_data['totaltax_total'];
						$states = getNameById('state',$b2b_data['party_state_id'],'state_id');
						if($b2b_data['invoice_type'] == 'domestic_invoice'){
							$invoiceTyppe = 'Domestic invoice';
						}elseif($b2b_data['invoice_type'] == 'export_invoice'){
							$invoiceTyppe = 'Export Invoice';
						}
						//descr_of_goods
						
						$cess_total = json_decode($b2b_data['invoice_total_with_tax']);
						$get_tax = json_decode($b2b_data['descr_of_goods']);
						 //pre($get_tax);
						// echo  $keycount += count($get_tax);
						foreach ($get_tax as $key => $item) 
						 {
							if ($item->tax > 0 )
							{
								$data[] = $item->tax;
							}
						 }
						$check_rcm = getNameById('ledger',$b2b_data['sale_ledger'],'id');
						if($check_rcm->enble_disbl_rcm == '1'){
							$checek_rcm_enabl_dsbl = 'Y';
						}elseif($check_rcm->enble_disbl_rcm == '0'){
							$checek_rcm_enabl_dsbl = 'N';
						}
						echo '<tr>';
						echo '<td>'.$b2b_data['gstin'].'</td>';
						echo '<td>'.$b2b_data['invoice_num'].'</td>';
						echo '<td>'.date("d-M-Y", strtotime($b2b_data['date_time_of_invoice_issue'])).'</td>';
						echo '<td>'.$total_value.'</td>';
						echo '<td>'.$b2b_data['party_state_id'].' - '.  $states->state_name  .'</td>';
						echo '<td>'.$checek_rcm_enabl_dsbl.'</td>';
						echo '<td></td>';
						echo '<td>'.$invoiceTyppe.'</td>';
						echo '<td></td>';
						echo '<td>'.$item->tax.'</td>';
						echo '<td>'.$b2b_data['total_amount'].'</td>';
						echo '<td>'.$cess_total[0]->cess_all_total.'</td>';
						
						echo '</tr>';
						//pre($b2b_data);
					
				}
			}
			?>
		</tbody>
	</table>	
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content4" aria-labelledby="profile-tab2" style="clear: both;"> 
	<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>Invoice Number</th>
				<th>Invoice date</th>
				<th>Invoice Value</th>
				<th>Place Of Supply</th>
				
				<th>Applicable % of Tax Rate</th>
				
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				<th>E-Commerce GSTIN</th>
				<th>Sale from Bonded WH</th>
				
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			 //if(!empty($invoice_data)){
				foreach($invoice_data as $b2cl_data){
					//pre($b2cl_data['total_amount']);
					if($b2cl_data['gstin'] =='' && $b2cl_data['total_amount'] > 250000){
						$total_value = $b2cl_data['total_amount'] -  $b2cl_data['totaltax_total'];
						$states = getNameById('state',$b2cl_data['party_state_id'],'state_id');
						
						
						$cess_total = json_decode($b2cl_data['invoice_total_with_tax']);
						$get_tax = json_decode($b2cl_data['descr_of_goods']);
						 //pre($get_tax);
						// echo  $keycount += count($get_tax);
						foreach ($get_tax as $key => $item) 
						 {
							if ($item->tax > 0 )
							{
								$data[] = $item->tax;
							}
						 }
						
						echo '<tr>';
						echo '<td>'.$b2cl_data['invoice_num'].'</td>';
						echo '<td>'.date("d-M-Y", strtotime($b2cl_data['date_time_of_invoice_issue'])).'</td>';
						echo '<td>'.$total_value.'</td>';
						echo '<td>'.$b2cl_data['party_state_id'].' - '.  $states->state_name  .'</td>';
						
						echo '<td></td>';
						echo '<td>'.$item->tax.'</td>';
						echo '<td>'.$b2cl_data['total_amount'].'</td>';
						echo '<td>'.$cess_total[0]->cess_all_total.'</td>';
						echo '<td></td>';
						echo '<td></td>';
						
						
						
						
						echo '</tr>';
						//pre($b2b_data);
					
				}
				// else{
					 // echo '<tr><td colspan="10"> No data Avilable</td></tr>';
				 // }
			}
	 
			?>
		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content5" aria-labelledby="profile-tab2" style="clear: both;"> 
	<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>Type</th>
				<th>Place Of Supply</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				<th>E-Commerce GSTIN</th>
				
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			 //if(!empty($invoice_data)){
				foreach($invoice_data as $b2cs_data){
					//pre($b2cs_data['total_amount']);
					if($b2cs_data['gstin'] =='' && $b2cs_data['total_amount'] < 250000){
						$total_value = $b2cs_data['total_amount'] -  $b2cs_data['totaltax_total'];
						$states = getNameById('state',$b2cs_data['party_state_id'],'state_id');
						
						
						$cess_total = json_decode($b2cs_data['invoice_total_with_tax']);
						$get_tax = json_decode($b2cs_data['descr_of_goods']);
						 //pre($get_tax);
						// echo  $keycount += count($get_tax);
						foreach ($get_tax as $key => $item) 
						 {
							if ($item->tax > 0 )
							{
								$data[] = $item->tax;
							}
						 }
						
						echo '<tr>';
						echo '<td>OE</td>';
						
						echo '<td>'.$b2cs_data['party_state_id'].' - '.  $states->state_name  .'</td>';
					
						echo '<td>'.$item->tax.'</td>';
						echo '<td>'.$b2cs_data['total_amount'].'</td>';
						echo '<td>'.$cess_total[0]->cess_all_total.'</td>';
						echo '<td></td>';
						
						echo '</tr>';
						//pre($b2b_data);
					
				}
				// else{
					 // echo '<tr><td colspan="10"> No data Avilable</td></tr>';
				 // }
			}
	 
			?>
		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content6" aria-labelledby="profile-tab2" style="clear: both;"> 
	<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				<th>Pre GST</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		
			foreach($credit_debit_notes as $data_cdnr){
				$cr_dr_data = json_decode($data_cdnr['credit_debit_party_dtl'],true);
				
						foreach($cr_dr_data as $cr_dr_dtl){
							
						if($cr_dr_dtl['cr_dr'] == 'debit'){
							 if($data_cdnr['party_gst'] != ''){
								echo '<tr>';
								echo '<td>'.$data_cdnr['total'].'</td>';
								echo '<td></td>';
								echo '<td>N</td>';
								echo '</tr>';
							 }
						}
					}
						
			}	
		
		?>

		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content7" aria-labelledby="profile-tab2" style="clear: both;"> 
	
		<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>UR Type</th>
				<th>Note/Refund Voucher Number</th>
				<th>Note/Refund Voucher date</th>
				<th>Document Type</th>
				<th>Invoice/Advance Receipt Number</th>
				<th>Invoice/Advance Receipt date</th>
				<th>Place Of Supply</th>
				<th>Note/Refund Voucher Value</th>
				<th>Applicable % of Tax Rate</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				<th>Pre GST</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		
			foreach($credit_debit_notes as $data_cdnur){
				$cr_dr_data = json_decode($data_cdnur['credit_debit_party_dtl'],true);
				
						// foreach($cr_dr_data as $cr_dr_dtl){
							// if($cr_dr_dtl['cr_dr'] == 'debit'){
								// if($data_cdnur['party_gst'] == ''){
							// }
						// }
					// }
					if($data_cdnur['invoice_num_add'] != 0){
						if($data_cdnur['total'] < 250000){
							$ur_type = 'Small';
						}else{
							$ur_type = 'Large';
						}
						$inv_advc_rcpt = getNameById('invoice',$data_cdnur['invoice_num_add'],'id');
						$cess_data = json_decode($inv_advc_rcpt->invoice_total_with_tax,true);
					
						$states = getNameById('state',$inv_advc_rcpt->party_state_id,'state_id');
						$get_tax = json_decode($inv_advc_rcpt->descr_of_goods);
						 // pre($inv_advc_rcpt->date_time_of_invoice_issue);
						 // pre($get_tax);
						
						foreach ($get_tax as $key => $item) 
						 {
							if ($item->tax > 0 )
							{
								$data[] = $item->tax;
							}
						 }
						
						echo '<tr>';
								echo '<td>'.$ur_type.'</td>';
								echo '<td>'.$data_cdnur['id'].'</td>';
								echo '<td>'.$data_cdnur['voucher_date'].'</td>';
								echo '<td></td>';
								echo '<td>'.$inv_advc_rcpt->invoice_num.'</td>';
								echo '<td>'.$inv_advc_rcpt->date_time_of_invoice_issue.'</td>';
								echo '<td>'.$inv_advc_rcpt->party_state_id.' - '.  $states->state_name  .'</td>';
								echo '<td>'.$data_cdnur['total'].'</td>';
								echo '<td></td>';
								echo '<td>'.$item->tax.'</td>';
								echo '<td>'.$cess_data[0]['total'].'</td>';
								echo '<td>'.$cess_data[0]['cess_all_total'].'</td>';
								echo '<td></td>';
								
								
						echo '</tr>';
					}
			}	
		
		?>

		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content8" aria-labelledby="profile-tab2" style="clear: both;">
<!-- Export Invoice -->	
	<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>Applicable % of Tax Rate</th>
				<th>Rate</th>
				<th>Taxable Value</th>
				<th>Cess Amount</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($invoice_data as $exp_inv_data){
					if($exp_inv_data['gstin'] =='' && $exp_inv_data['invoice_type']=='export_invoice'){
					
						$total_value = $exp_inv_data['total_amount'] -  $exp_inv_data['totaltax_total'];
						$cess_total = json_decode($exp_inv_data['invoice_total_with_tax']);
						$get_tax = json_decode($exp_inv_data['descr_of_goods']);
						foreach ($get_tax as $key => $item) 
						 {
							if ($item->tax > 0 )
							{
								$data[] = $item->tax;
							}
						 }
						
						echo '<tr>';
						echo '<td></td>';
						echo '<td>'.$item->tax.'</td>';
						echo '<td>'.$total_value.'</td>';
						echo '<td>'.$cess_total[0]->cess_all_total.'</td>';
						echo '</tr>';
						//pre($b2b_data);
					
				}
				// else{
					 // echo '<tr><td colspan="10"> No data Avilable</td></tr>';
				 // }
			}
	 
			?>
		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content9" aria-labelledby="profile-tab2" style="clear: both;"> 
	<!-- at advance Recived -->
		<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>Place Of Supply</th>
				<th>Rate</th>
				<th>Gross Advance Received</th>
				<th>Cess Amount</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
					<?php 
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';

					
					?>
						
		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content10" aria-labelledby="profile-tab2" style="clear: both;"> 
	
	<!-- atadj advance adjustment -->
		<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>Place Of Supply</th>
				<th>Rate</th>
				<th>Gross Advance Received</th>
				<th>Cess Amount</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
					<?php 
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';

					
					?>
						
		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content11" aria-labelledby="profile-tab2" style="clear: both;"> 
	
	<!-- Nil Rated  exemp-->
	<table class="table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>Exempted (other than nil rated/non GST supply )</th>
				<th>Non-GST supplies</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($invoice_data as $nill_rated_exp_data){
					if($nill_rated_exp_data['totaltax_total'] == '0'){
					echo '<tr>';
					echo '<td>'.$nill_rated_exp_data['total_amount'].'</td>';
					echo '<td></td>';
					echo '</tr>';
						
					}
			}
	 
			?>
		</tbody>
	</table>
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content12" aria-labelledby="profile-tab2" style="clear: both;"> 
	
	<!-- hsn  -->
	<table class="table table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>HSN</th>
				<th>Description</th>
				<th>UQC</th>
				<th>Total Quantity</th>
				<th>Total Value</th>
				<th>Taxable Value</th>
				<th>Integrated Tax Amount</th>
				<th>Central Tax Amount</th>
				<th>State/UT Tax Amount</th>
				<th>Cess Amount</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$finalArray = array();
			foreach($invoice_data as $hsn_data){
					$products = json_decode($hsn_data['descr_of_goods']);
					    
								if(!empty($products)){
									$w = 0;
									$mat_num = 1;
									foreach($products as $dtl_prod){
						
						$uom_nam = getNameById('uom',$dtl_prod->UOM,'id');
						
						// pre($dtl_prod);
						 
						if($uom_nam->id == $dtl_prod->UOM){
							$product_qty = $dtl_prod->quantity;
						}
						$total_mat_amt = $dtl_prod->amount - $dtl_prod->added_tax_Row_val;
						if($hsn_data['IGST'] !='' && $hsn_data['SGST'] == '0.00' && $hsn_data['CGST'] == '0.00' ){	
							$igst = $hsn_data['IGST'];
						}elseif($invoice['IGST'] =='0.00' && $invoice['SGST']!= '' && $invoice['CGST'] != ''){	
							$camt = $hsn_data['CGST'];	
							$samt = $hsn_data['SGST'];
						}	
						echo '<tr>';
						echo '<td>'.$dtl_prod->hsnsac.'</td>';
						echo '<td>'.$dtl_prod->descr_of_goods.'</td>';
						echo '<td>'.$uom_nam->ugc_code.' - '. $uom_nam->uom_quantity .'</td>';
						echo '<td>'.$product_qty.'</td>';
						echo '<td>'.$dtl_prod->amount.'</td>';
						echo '<td>'.$total_mat_amt.'</td>';
						echo '<td>'.$igst.'</td>';
						echo '<td>'.$camt.'</td>';
						echo '<td>'.$samt.'</td>';
						echo '<td>'.$dtl_prod->cess.'</td>';
						
						
						echo '</tr>';
					}
					//pre($hsn_array);
									
			}
								
					
			}
			
				
			?>
		</tbody>
	</table>	
	
	</div>
	<div role="tabpanel" class="col-md-12 col-sm-12 col-xs-12  tab-pane fade " id="tab_content13" aria-labelledby="profile-tab2" style="clear: both;"> 
	<!-- Docs  -->
		<table class="table-striped table-bordered" style="width:100%" border="1" cellpadding="3" >
		<thead>
			<tr>
				<th>Nature of Document</th>
				<th>Sr. No. From</th>
				<th>Sr. No. To</th>
				<th>Total Number</th>
				<th>Cancelled</th>
				<th style="display:none;">Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				
			?>
		</tbody>
	</table>
	
	</div>
</div>
		</div>
	</div>

