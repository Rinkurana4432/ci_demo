<!--style type="text/css">
   @import url(http://busybanda.com/assets/plugins/bootstrap/dist/css/bootstrap.min.css) print;
   id="print_divv"
</style-->
<div class="col-md-12 col-sm-12 col-xs-12 "  style="padding:0px;">
   <div class="table-responsive">
      <h3 class="Material-head">
         Supplier Name : <?php if(!empty($supplier)){ echo $supplier->name; } ?>
         <hr>
      </h3>
      <div class="col-md-6 col-xs-12 label-right"  style=" padding:0px;">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Supplier Code :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div ><?php if(!empty($supplier)){ echo $supplier->supplier_code; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Account Group :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div ><?php if(!empty($supplier)){
                              echo $parent_group = getNameById('account_group',$supplier->supp_account_group_id,'id')->name;
                  } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Address :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div ><?php if(!empty($supplier)){ echo $supplier->address; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">GSTIN :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div ><?php if(!empty($supplier)){ echo $supplier->gstin; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Mailing Name :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div ><?php if(!empty($supplier)){ echo $supplier->mailing_name; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Country :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div ><?php 
                  if(!empty($supplier)){
                  	$country = getNameById('country',$supplier->country,'country_id');
                  	if(!empty($country)){echo $country ->country_name; } else {echo "NULL" ;}
                  }
                  ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">State :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div ><?php 
                  if(!empty($supplier)){
                  	$state = getNameById('state',$supplier->state,'state_id');
                  	if(!empty($state)){echo $state ->state_name;} else {echo "NULL";}
                  }
                  ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">City :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div ><?php 
                  if(!empty($supplier)){
                  	$city = getNameById('city',$supplier->city,'city_id');
                  	if(!empty($city)){echo $city ->city_name;} else{echo "NULL";}
                  }
                  ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Website :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div><?php if(!empty($supplier)){ echo $supplier->website; } ?></div>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-xs-12 label-right"  style=" padding:0px;">
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label for="material">Bank Name :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div><?php  if(!empty($supplier)){
                  $bankName = getNameById('bank_name',$supplier->bank_name,'bankid');
                  if(!empty($bankName)){echo $bankName ->bank_name;} else{ echo "N/A";}
                  }?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Branch Name :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div><?php if(!empty($supplier)){ echo $supplier->branch_name; } ?></div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Account Number :</label>	
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div>
                  <?php if(!empty($supplier)){ echo $supplier->account_no; } ?>										
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>IFSC Code :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div>
                  <?php if(!empty($supplier)){ echo $supplier->ifsc_code; } ?>							
               </div>
            </div>
         </div>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Other :</label>
            <div class="col-md-7 col-sm-7 col-xs-6 form-group">
               <div><?php if(!empty($supplier)){ echo $supplier->other; } ?>								
               </div>
            </div>
         </div>
         <?php if(!empty($idproof)){ ?>
         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label>Id :</label>
            <div class="item form-group">
               <div class="col-md-7">
               <?php foreach($idproof as $proof){   
                  echo '<div class="col-md-4">
                          <div class="image view view-first">
                             <img style="display: block;" src="'.base_url().'assets/modules/purchase/uploads/'.$proof['file_name'].'" alt="image" class="undo" height="100" width="100"/> <a download href="'.base_url().'assets/modules/purchase/uploads/'.$proof['file_name'].'"><i class="fa fa-download"></i></a>
                          </div>
                        </div>'; 
					
               } ?>
               </div>
            </div>
         </div>
         <?php } ?>
      </div>
      <hr>
      <div class="bottom-bdr"></div>
      <div class="col-md-12 col-xs-12">
         <h3 class="Material-head">
            Material Detail
            <hr>
         </h3>
         <div class="well col-md-12 pro-details" id="chkIndex_1" >
            <div class="col-container mobile-view2">
               <!--div class="col-md-3 col-sm-12 col-xs-12 form-group">Material Type</div-->
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">Material Name</div>
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">UMO</div>
               <!--div class="col-md-2 col-sm-12 col-xs-12 form-group">Date</div-->
               <div class="col-md-2 col-sm-12 col-xs-12 form-group">Price</div>
            </div>
            <?php 
            if( !empty($supplier->material_name_id)  ){
               $data = json_decode($supplier->material_name_id);
               if( !empty($data) ){
                     foreach ($data as $key => $value) { 
					$getMatType =  getNameById('material',$value->material_name,'id');
					
                        ?>
                        <div class="col-container mobile-view2">
                           <!--div class="col-md-3 col-sm-12 col-xs-12 form-group"><?//= getSingleNameById('name','material_type',$getMatType->material_type_id,'id'); ?></div-->
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group"><?= getSingleNameById('material_name','material',$value->material_name,'id'); ?></div>
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group"><?= $value->uom??'N/A'; ?></div>
                           <!--div class="col-md-2 col-sm-12 col-xs-12 form-group"><?//= $value->supplierDeliveryDate ?></div-->
                           <div class="col-md-2 col-sm-12 col-xs-12 form-group"><?= $value->price ?></div>
                        </div>      
               <?php }

                }
             }
            ?>
         </div>
      </div>
      <div class="col-md-12 ">
         <h3 class="Material-head">
            Contact Details
            <hr>
         </h3>
         <div class="well pro-details" id="chkIndex_1" >
            <?php 
               if(!empty($supplier) && $supplier->contact_detail !=''){	?>
            <div class="col-container mobile-view2">
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">Contact Name</div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">Email ID</div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">Designation</div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">Contact Number</div>
            </div>
            <?php
               $contactInfo =  json_decode($supplier->contact_detail);  
               if(!empty($contactInfo)){
               	foreach($contactInfo as $contact_info){ ?>
            <div class="row-padding col-container mobile-view view-page-mobile-view">
               <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
                  <label>Contact Name</label>
                  <div><?php echo $contact_info->contact_detail; ?></div>
               </div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
                  <label>Email ID</label>
                  <div><?php echo $contact_info->email;?></div>
               </div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
                  <label>Designation</label>
                  <div><?php echo $contact_info->designation;?></div>
               </div>
               <div class="col-md-3 col-sm-12 col-xs-12 form-group col">
                  <label>Mobile</label>
                  <div><?php echo $contact_info->mobile;?></div>
               </div>
            </div>
            <?php	}
               }                                    
               ?>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
<!--<table class="fixed data table table-bordered no-margin" style="width:100%" id="print_divv" border="1" cellpadding="2">												
   <thead>													
   	<tbody>	
   		<tr>						
   			<th>Supplier Code:</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->supplier_code; } ?></td>
   		</tr>
   		<tr>					
   			<th>Supplier Name:</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->name; } ?></td>						
   		</tr>
   		<tr>						
   			<th>Address</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->address; } ?></td>	
   		</tr>
   		<tr>					
   			<th>GSTIN:</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->gstin; } ?></td>					
   		</tr>
   		<tr>						
   			<th>Country:</th>						
   			<td><?php 
      if(!empty($supplier)){
      	$country = getNameById('country',$supplier->country,'country_id');
      	if(!empty($country)){echo $country ->country_name; } else {echo "NULL" ;}
      }
      ?>
   			</td>
   		</tr>
   		<tr>				
   			<th>State:</th>						
   			<td><?php 
      if(!empty($supplier)){
      	$state = getNameById('state',$supplier->state,'state_id');
      	if(!empty($state)){echo $state ->state_name;} else {echo "NULL";}
      }
      ?>
   			</td>							
   		</tr>
   		<tr>						
   			<th>City:</th>						
   			<td><?php 
      if(!empty($supplier)){
      	$city = getNameById('city',$supplier->city,'city_id');
      	if(!empty($city)){echo $city ->city_name;} else{echo "NULL";}
      }
      ?>
   			</td>
   		</tr>
   		<tr>				
   			<th>Website:</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->website; } ?></td> 					
   		</tr>
   		<tr>
   			<th>Material Detail:</th>						
   				<td colspan="3">
   					<?php if(!empty($supplier) && $supplier->material_name_id !=''  && $supplier->material_name_id != '[{"material_name_id":"","uom":""}]' ){ ?>
   						<table class="fixed data table table-bordered no-margin" style="width:100%" border="1" cellpadding="2">
   							<thead>
   								<tbody>
   									<tr>
   										<th colspan="2">Material Name</th>
   										<th colspan="2">UOM</th>
   									</tr>
   									<?php 
      $materialDetail =  json_decode($supplier->material_name_id);
      foreach($materialDetail as $material_detail){
      	$material_id=$material_detail->material_name_id;
      	$materialName=getNameById('material',$material_id,'id'); ?>		
   											<tr>
   												<td colspan="2"><?php if(empty($materialName)){echo "Null";} else{ echo $materialName->material_name; }?><br /></td>
   												<td colspan="2"><?php  echo $material_detail->uom; ?><br /></td>
   											</tr>
   										<?php  } ?>
   								</tbody>
   							</thead>
   						</table> 
   					<?php } ?>
   				</td>		
   		</tr>	
   		<tr>						
   			<th>Bank Name:</th>						
   			<td><?php  if(!empty($supplier)){
      $bankName = getNameById('bank_name',$supplier->bank_name,'bankid');
      if(!empty($bankName)){echo $bankName ->bank_name;} else{ echo "N/A";}
      }?>
   			</td>
   		</tr>
   		<tr>				
   			<th>Branch Name:</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->branch_name; } ?></td>
   		</tr>					
   		<tr>						
   			<th>Account Number:</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->account_no; } ?></td>
   		</tr>	
   		<tr>
   			<th>IFSC Code:</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->ifsc_code; } ?></td>
   		</tr>
   		<tr>
   			<th>Other:</th>						
   			<td><?php if(!empty($supplier)){ echo $supplier->other; } ?></td>
   		</tr>	
   		<tr>			
   			<th>Contact Details:</th>						
   			<td  colspan="3">
   				<?php 
      if(!empty($supplier) && $supplier->contact_detail !=''){	?>
   						<table class="fixed data table table-bordered no-margin" style="width:100%" border="1" cellpadding="2">
   							<thead>
   								<tbody>
   									<tr>
   										<th>Contact Name</th>
   										<th>Email ID</th>
   										<th>Designation</th>
   										<th>Mobile</th>
   									</tr>
   									<?php
      $contactInfo =  json_decode($supplier->contact_detail);  
      if(!empty($contactInfo)){
      	foreach($contactInfo as $contact_info){ ?>		
   													<tr>
   														<td><?php echo $contact_info->contact_detail; ?><br /></td>
   														<td><?php echo $contact_info->email;?><br /></td>
   														<td><?php echo $contact_info->designation;?><br /></td>
   														<td><?php echo $contact_info->mobile;?><br /></td>
   													</tr>
   										<?php	}
      }                                    
      ?>
   								</tbody>
   							</thead>
   						</table>
   						<?php } ?>
   					</td>									
   		</tr>	
   		<tr>
   			<td rowspan="2" colspan="10">
   				<h4>Id Proof:</h4>												
   				<div class="x_content">							
   					<div class="row">									
   						<div class="col-md-6">									
   							<?php if(!empty($idproofs)){										
      foreach($idproofs as $proofs){								
      	echo '<div  class="col-md-55"><div class="image view view-first"><img style="display: block;" src="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'" alt="image" height="100" width="100"/></div></div>';				
      }
      } ?>									
   						</div>							
   					</div>                          						
   				</div>	
   			</td>
   		</tr>	
   				
   	</tbody>												
   </thead>												
   </table>-->
<div class="col-md-12 col-xs-12">
   <!--center style="clear: both;padding-top: 20px;">
      <button class="btn edit-end-btn hidden-print"  id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
   </center-->
</div>