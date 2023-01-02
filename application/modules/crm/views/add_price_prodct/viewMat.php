<div class="table-responsive">
<div class="container mt-3">
	<div class="well pro-details" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; ; margin-top: 15px;">
	
	 <table id="" style="width:100%" class="table table-bordered product_index  bulk_action" data-id="user" border="1" cellpadding="3">
                           <thead>
                              <tr>
                                 <th>Compiteter Name</th>
                                 <th>Description</th>
                                 <th>Price</th>                                            
                              </tr>
                           </thead>
                           <?php 
                           if($prdtl !=''){
                                 $products = json_decode($prdtl->comp_price_info);
                                 foreach($products as $product){
                                    $comp_id = getNameById('competitor_details',$product->compt_id,'id');
                                    #pre($comp_id);
                                    $comp_name = !empty($comp_id)?$comp_id->name:'';
                                    echo "<tr>
                                          <td><h5>".$comp_name."</td>
                                          <td>".$product->disc."</td>
                                          <td>".$product->price."</td>
                                       </tr>";
                                 } 
                              }
                              echo "</table>";
							  ?>
												   
			 </div>
			 </div>
			<div class="modal-footer">
				<input type="hidden" id="add_contactPerson_Data_onthe_spot">
				<button type="button" class=" btn btn-default" data-dismiss="modal">Close</button>
				
			</div>
	