<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	
<table id="datatable-buttons" class="table table-striped table-bordered" cellpadding="2">
		<thead>
			<tr>
				<th>List of Exceptions</th>
				<th>Total</th>
				<th> Check </th>
			</tr>
		</thead>
		<tbody>
		 
		   <?php 
		  // pre($get_inwards_purchase);
		   if(!empty($get_inwards_purchase)){
			   $gstin_invalid_count = 0;
			   $hsn_number = array();
			   $sno = 1;
				foreach($get_inwards_purchase as $gt_new_purchase){
					$party_dtail  = getNameById('ledger',$gt_new_purchase['supplier_name'],'id');
					
					$gst= $party_dtail->gstin; 
					
					if (!preg_match("/^([0-9]){2}([A-Za-z]){5}([0-9]){4}([A-Za-z]){1}([0-9]{1})([A-Za-z]){2}?$/", $gt_new_purchase['gstin'])) { //GSTN validation
							$gstin_invalid_count++ ;
					}
					
					$check_hsn_number = json_decode($gt_new_purchase['descr_of_bills'],true);
					foreach($check_hsn_number as $gt_new_hsn){
						
						$hsn_number[] = $gt_new_hsn['hsnsac'];
						
					}
				
				}
				
				if($gstin_invalid_count > 0){
						echo '<tr><td> GST Number Not valid  </td><td>'.$gstin_invalid_count.'</td><td><i class="fa fa-eye btn-view  btn  btn-xs" id="invalid_gst"></i></td> </tr>';
					}
					
				if(!empty($hsn_number)){
						$hsn_not_valid_count = 0;
						foreach($hsn_number as $chk_hsn){
							 $hsn_len =  strlen($chk_hsn);
						
							if($chk_hsn == 0 || $hsn_len < 4 ){
								$hsn_not_valid_count++;
							}
							
						}
						if($hsn_not_valid_count > 0){
							echo '<tr><td> InCorrrect HSN/SAC Number  </td><td>'.$hsn_not_valid_count.'</td><td ><i class="fa fa-eye btn-view  btn  btn-xs" id="click_hsnsac"></i></a></td></tr>';	
						}
					} 
				}
			
			?>
			
		</tbody>                   
	</table>

</div>
<form name="gst" method="post" id="gst_form" action="<?php echo base_url(); ?>account/ledgers"> 
<?php
		foreach($get_inwards_purchase as $gt_new_purchase){
			//pre($gt_new_purchase);
			if (!preg_match("/^([0-9]){2}([A-Za-z]){5}([0-9]){4}([A-Za-z]){1}([0-9]{1})([A-Za-z]){2}?$/", $gt_new_purchase['gstin'])) { //GSTN validation
				echo '<input type="hidden" name="gst_number[]" value="'.$gt_new_purchase['supplier_name'].'" >';	
			}
		}
?>
</form>

<form name="gst" method="post" id="chk_form" action="<?php echo base_url(); ?>account/purchase_bill"> 
<?php
		foreach($get_inwards_purchase as $gt_new_purchase){
				echo '<input type="hidden" name="hsnsac_number[]" value="'.$gt_new_purchase['id'].'" >';	
			}

		
?>
</form>


