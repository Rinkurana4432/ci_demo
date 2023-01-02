<div id="print_divv" class="col-md-12 col-sm-12 col-xs-12"  style="padding:0px;"> 
<div class="item form-group col-md-12 col-sm-12 col-xs-12">
	<!-- <div class="col-md-4">
		Date Range Picker	:<?php if(!empty($userSaleTarget))  echo $userSaleTarget[0]['start_date'];  ?>
		
	</div> -->
</div>	

<div class="container mt-3">
		<div class="well" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important;  margin-top: 15px;">
		    <div class="label-box">
			       <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>User Name</label></div>
				   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Sale Target</label></div>
				   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Lead Generaion Target</label></div>
				   <div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Payment Target</label></div>				                				   
			 </div>
<div class="row-padding">
			 <?php
		if(!empty($userSaleTarget)){
			foreach($userSaleTarget as $ust){
				echo '<div class="col-md-3 col-sm-12 col-xs-12 form-group">
					<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><strong> '.$ust['name'].'</strong></div>';		 ?>		
					<?php
						//$where = ' AND created_by ='.$ust["u_id"] .' AND created_date = date_format('.$ust['start_date'].',"%Y-%m")'; 
						$startDate = date("Y-m", strtotime($ust['start_date']));
						$whereAcheivedLeadTarget = ' AND created_by ='.$ust["u_id"] .' AND created_date like("'.$startDate.'%")';
						$whereAcheivedSaleTarget = ' created_by ='.$ust["u_id"] .' AND created_date like("'.$startDate.'%")';
						$acheivedPaymentTarget = getAcheivedPaymentTargetByUserIdAndDate($ust["u_id"] , $startDate);
						$acheivedPaymentTarget = $acheivedPaymentTarget[0]['acheivedPaymentTarget']? $acheivedPaymentTarget[0]['acheivedPaymentTarget'] :0;
						$ust['sale_target'] = $ust['sale_target']?$ust['sale_target']:0;
						$ust['lead_generation_target'] = $ust['lead_generation_target']?$ust['lead_generation_target']:0;
						$ust['payment_target'] = $ust['payment_target']?$ust['payment_target']:0;
						
						
						?>	</div>
														
	 
									       <div class="col-md-3 col-sm-12 col-xs-12 form-group">
											<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><b><?php if(!empty($ust)) { echo total_rows('sale_order',' '. $whereAcheivedSaleTarget) . ' / ' . $ust['sale_target']; }?></b></div>
									
								          </div>
										  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
											<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><b><?php if(!empty($ust)) { echo total_rows('leads','lead_status=5 '. $whereAcheivedLeadTarget) . ' / ' .$ust['lead_generation_target']; }?></b></div>
									
								          </div>
										  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
											<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"><b><?php if(!empty($ust)) echo $acheivedPaymentTarget.' / '.$ust['payment_target']; ?></b></div>
									
								          </div>
										  
     										  
						
						
						<?php }
			}
			?>	
	</div>
		</div>
</div>				
<!--<table class="table table-bordered bulk_action table-responsive">		
	<thead><th>User Name</th><th>Sale Target</th><th>Lead Generaion Target</th><th>Payment Target</th></thead>
	<tbody>	
		<?php
		if(!empty($userSaleTarget)){
			foreach($userSaleTarget as $ust){
				echo '<tr>
					<td width="15%"><strong> '.$ust['name'].'</strong></td>';		?>		
					<?php
						//$where = ' AND created_by ='.$ust["u_id"] .' AND created_date = date_format('.$ust['start_date'].',"%Y-%m")'; 
						$startDate = date("Y-m", strtotime($ust['start_date']));
						$whereAcheivedLeadTarget = ' AND created_by ='.$ust["u_id"] .' AND created_date like("'.$startDate.'%")';
						$whereAcheivedSaleTarget = ' created_by ='.$ust["u_id"] .' AND created_date like("'.$startDate.'%")';
						$acheivedPaymentTarget = getAcheivedPaymentTargetByUserIdAndDate($ust["u_id"] , $startDate);
						$acheivedPaymentTarget = $acheivedPaymentTarget[0]['acheivedPaymentTarget']? $acheivedPaymentTarget[0]['acheivedPaymentTarget'] :0;
						$ust['sale_target'] = $ust['sale_target']?$ust['sale_target']:0;
						$ust['lead_generation_target'] = $ust['lead_generation_target']?$ust['lead_generation_target']:0;
						$ust['payment_target'] = $ust['payment_target']?$ust['payment_target']:0;
						
						
						?>					
					<td><?php if(!empty($ust)) { echo total_rows('sale_order',' '. $whereAcheivedSaleTarget) . ' / ' . $ust['sale_target']; }?></td>
					<td><?php if(!empty($ust)) { echo total_rows('leads','lead_status=5 '. $whereAcheivedLeadTarget) . ' / ' .$ust['lead_generation_target']; }?></td>
					<td><?php if(!empty($ust)) echo $acheivedPaymentTarget.' / '.$ust['payment_target']; ?></td>
				</tr>
			<?php }
			}
			?>							
	</tbody>										
</table>-->
</div> 
<center>
					
	 <button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	
	</center>
