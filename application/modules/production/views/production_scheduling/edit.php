<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
         <div class="x_title">
		 
		 <div id="sortableKanbanBoards" class="row">

            <!--sütun başlangıç-->
            <div class="panel panel-primary kanban-col" style="width:100%">
                <div class="panel-heading">
                    Set Sale order Priority
                    <i class="fa fa-2x fa-plus-circle pull-right"></i>
                </div>
               <?php /* <div class="panel-body droptarget"> */?>
                <div class="panel-body">
					<div id="TODO" class="kanban-centered">
						<?php if(!empty($sale_orders)){
								    $i = 0;
								    foreach($sale_orders as $sale_order){ 
										$i++;
										$accountName = ($sale_order['account_id']!=0)?(getNameById('account',$sale_order['account_id'],'id')):'';
										$accountName = !empty($accountName)?$accountName->name:'';										
										$contactName = ($sale_order['contact_id']!=0)?(getNameById('contacts',$sale_order['contact_id'],'id')):'';
										if(!empty($contactName)){
											$contactName = $contactName->first_name.' '.$contactName->last_name;
										}else{
											$contactName = '';
										}
										
										$validatedBy = ($sale_order['validated_by']!=0)?(getNameById('user_detail',$sale_order['validated_by'],'id')):'';
										if(!empty($validatedBy)){
											$validatedByName = $validatedBy->name;
										}else{
											$validatedByName = '';
										}				
										
										$selectApprove = $sale_order['approve']==1?'checked':'';
										$selectDisapprove = $sale_order['disapprove']==1?'checked':'';
										$products = json_decode($sale_order['product']);
										
										
										$createdByData = getNameById('user_detail',$sale_order['created_by'],'u_id');
										if(!empty($createdByData)){
											$createdByName = $createdByData->name;
										}else{
										$createdByName = '';
										}?>
										<article class="kanban-entry grab saleOrder" id="item<?php echo $i; ?>" data_sale_order_priority_id="<?php echo $sale_order['sale_order_priority_id'];?>"  data_sale_order_id="<?php echo $sale_order['sale_order_id'];?>" draggable="true" data-product="<?php echo $sale_order['product']; ?>" data_priority="<?php echo $sale_order['priority']; ?>">
										<div class="kanban-entry-inner">
											<div class="kanban-label" data_sale_order_id="<?php echo $sale_order['sale_order_id'];?>">	
												<?php echo "Sale Order Priority Id : ".$sale_order['sale_order_priority_id']."                   |                   Sale Order Id : ".$sale_order['sale_order_id']."                   |                   Account Name : ".$accountName. "                  |                   Contact Name : ".$contactName."                   |                   Order Date : ".$sale_order['order_date']."                   |                   Dispatch Date : ".$sale_order['dispatch_date']."                   |                   Payment Terms : ".$sale_order['payment_terms']."                   |                   Disapprove Reason : ".$sale_order['disapprove_reason']."                   |                   Validated By : ".$validatedByName."                   |                   Created By : ".$createdByName."                   |                   Created Date: ".$sale_order['created_date']."<br>Product Name : ".getNameById('material',$sale_order['product_id'],'id')->material_name."                   |                   Quantity :".$sale_order['quantity']."                   |                   UOM : ".$sale_order['uom']."                   |                   Price :".$sale_order['price']."                   |                   GST: ".$sale_order['gst']."                   |                   Price: ".$sale_order['individualTotal']."                   |                   Total Price: ".$sale_order['individualTotalWithGst']; ?>
												</div>
											</div>
									</article>															
								<?php echo "</tr>";?>

										<?php	} } ?>
						
                    </div>
					
					
                </div>
            </div>
        </div>
    </div>


    <!-- Static Modal -->
    <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa-spin"></i>
                        <h4>Processing...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
		
		<?php   /* kan Ban */ ?>
		<input type="button" value="Schedule your production" id="pro">
		 
		 
		 
		   <form method="post" class="form-horizontal" action="" enctype="multipart/form-data" id="updateProductionScheduling" novalidate="novalidate" style="">	
			<?php if(!empty($productionScheduling)){ echo  '<input type="hidden" name="id" value="'.$productionScheduling->id.'">'; } ?>
				<?php
					if(empty($productionScheduling)){
				?>
				<input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
				<?php }else{ ?>	
				<input type="hidden" name="created_by" value="<?php if($productionScheduling && !empty($productionScheduling)){ echo $productionScheduling->created_by;} ?>" >
				<?php } ?>
		   <div class='col-sm-4'>
                    Only Date Picker
                    <div class="form-group">
                        <div class='input-group date' id='psMonthYear'>
                            <input type='text' class="form-control" id="selectedMonth" name="date" readonly value="<?php if(!empty($productionScheduling)){ echo  $productionScheduling->date;} ?>"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
					  <div class="x_content" style="overflow:scroll;">
						 <table class="table table-bordered" id="daysss"  class="display">
							<?php	
							if(!empty($productionScheduling)){
								$boxes = '';
								$days = 28;
								$mcLength = count($machines) + 1;
								$selectedMonth = 2;
								$CurrentYear = 2019;
								$uom='';
								$measurementUnits = getUom();
								$prod = $productionScheduling->data;
								$prodSch = json_decode($prod);
								$prodSchCount = count($prodSch) + 1;
								//for($i=0; $i < $prodSchCount; $i++){
								for($i=0; $i < $prodSchCount; $i++){
									$boxes .= '<tr>';
									if($i==0){
										$boxes .='<td>Machine Name</td>';
									}else if($i >=1 ){
										$machine = getNameById('add_machine',$prodSch[$i-1]->machine,'id');
										if(!empty($machine)){
											$boxes .= '<td><input type="hidden" name="prodSch['.$i.'][machine].machine[]" value="'.$prodSch[$i-1]->machine.'">'.$machine->machine_name.'</td>';
										}else{
											$boxes .= '<td>';
										}
									}	
									if($i==0){
										for($j = 1; $j <= $days ; $j++){
											foreach($productionSetting as $shift){
												$boxes .= '<td>';
												$boxes .= $j . ' / ' . $selectedMonth . ' /' . $CurrentYear .' ('.$shift['shift_name'].')' ;
												$boxes .= '</td>';
											}											
										}
									}										
								else if($i >=1 ){
										$l=1;
										for($k = 1; $k <= $days ; $k++){										
											foreach($productionSetting as $shift){
												$boxes .= '<td>';
												//pre($prodSch[$i-1]->job_card->$l);
												//$jobCard = getNameById('job_card',$prodSch[$i-1]->job_card->$l,'id');
												//pre($jobCard->job_card_no);
												$boxes .= '<select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" required="required" name="prodSch['.$i.'][job_card]['.$l.'].job_card[]" data-id="job_card" data-key="id" data-fieldname="job_card_no" tabindex="-1" aria-hidden="true" data-where="created_by_cid='.$_SESSION['loggedInUser']->c_id.' AND save_status = 1"><option value="">Select Option</option>';
												if(!empty($prodSch[$i-1]->job_card->$l)){
													$jobCard = getNameById('job_card',$prodSch[$i-1]->job_card->$l,'id');
													if(!empty($jobCard)){
														$boxes .= '<option value="'.$prodSch[$i-1]->job_card->$l.'" selected>'.$jobCard->job_card_no.'</option>';
													}
												}
												$boxes .= '</select><br><br>';
												$boxes .= '<input type="number" name="prodSch['.$i.'][production]['.$l.'].production[]" value="'.$prodSch[$i-1]->production->$l.'" class="production"><br><br><select class="form-control" name="prodSch['.$i.'][uom]['.$l.'].uom[]" class="uom">';
												foreach( $measurementUnits as $mu ) {
													$uomSelected = '';
													if($prodSch[$i-1]->uom->$l == $mu){
														$uomSelected = 'selected';
													}else{
														$uomSelected = '';
													}
													$boxes .= '<option value="'.$mu.'" '.$uomSelected.'>'.$mu.'</option>';	
												}
												$boxes .= '</select>';
												$boxes .= '</td>';
												$l++;
											}
										}
									}
								}
								$boxes .= '</tr>';
								echo $boxes; 
							} ?>
						   </table> 
					  </div>               
					<div class="shifts" style="display:none;"><?php echo $shifts; ?></div>
					<div class="machine_name" style="display:none;"><?php echo $machine_name; ?></div>
					<div class="machine_id" style="display:none;"><?php echo $machine_id; ?></div>
						<?php if((!empty($productionScheduling) && $productionScheduling->save_status !=1) || empty($productionScheduling)){
									echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
							}?> 
					<input type="submit" value="Update" id="update">
				</form>
				
		</div>
	</div>
</div>
<script>
		var measurementUnits = <?php echo json_encode(getUom()); ?>;	
		var jobCards = '<?php echo json_encode($jobCards); ?>';	
		var machines = '<?php echo json_encode($machines); ?>';	

	</script>
