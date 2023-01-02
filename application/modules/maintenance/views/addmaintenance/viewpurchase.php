<h3 class="Material-head">
   Purchase details
   <hr>
</h3>
<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv" style="padding:0px;">
<div >
   <div class=" col-md-6 col-xs-12 col-sm-6 label-left   " style="overflow:auto; padding:0px;">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material">For Company Unit:<span class="required">*</span></label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div><b><?php if(!empty($indents)){ echo $indents->company_unit; } ?></b></div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Material Type:</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php if(!empty($materialType)){ 
                  $indents->material_type_id;                                    
                  $material_type=getNameById('material_type',$indents->material_type_id,'id')->name;                     
                  }                       
                  ?> 
               <?php echo $material_type;?>											
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Inductor:</label>	
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php if(!empty($indents)){ echo $indents->inductor; } ?>										
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Indent Number :</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php echo $indents->indent_code; ?>									
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Preferred Supplier</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php if(!empty($suppliername)){                                  
                  $indents->preffered_supplier;                                   
                  $supplierName=getNameById('supplier',$indents->preffered_supplier,'id');                     
                  					 
                  ?>                      
               <?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
               <?php }?>								
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Validate By</label>								
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php 
                  // pre($indents);
                    if(!empty($indents)){                                  
                  									  
                  	 $username = getNameById('user_detail',$indents->validated_by,'u_id');                     
                  	echo $username->name;
                    }
                  	?> 									
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-xs-12 col-sm-6 label-left " style=" padding:0px;">
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label for="material">Required Date:<span class="required">*</span></label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div ><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->required_date)); } ?></div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Created Date:</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div ><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->created_date)); } ?></div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label >Department:</label>	
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div >
               <?php if(!empty($indents)){ echo $indents->departments; } ?>										
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Others:</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div>
               <?php if(!empty($indents)){ echo $indents->other; } ?>									
            </div>
         </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <label>Specification:</label>
         <div class="col-md-7 col-sm-12 col-xs-6">
            <div ><?php if(!empty($indents)){ echo $indents->specification; } ?>								
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="container mt-3">
      <h3 class="Material-head">
         Material Description
         <hr>
      </h3>
      <div class="well pro-details" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; border:0px; margin-top: 15px; margin-bottom:0px;">
         <?php 
            if(($indents->material_name != '') && ($indents->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]')) {  ?>
         <div class="col-container mobile-view2">
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Material Name</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Quantity</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Purpose</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Preffered Supplier</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group">Expected Amount</div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1;">Total Amount</div>
         </div>
         <?php 
            if(!empty($indents) && $indents->material_name !='' && $indents->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]'){					
            	$materialDetail =  json_decode($indents->material_name); 
            	$Total=0;									
            	foreach($materialDetail as $material_detail){
            	$material_id=$material_detail->material_name_id;
            	$materialName=getNameById('material',$material_id,'id');
            	$Total+=$material_detail->sub_total;	
            	 
            	
            	?>
         <div class="row-padding col-container mobile-view view-page-mobile-view">
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Material Name</label>
               <div><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></h5>&nbsp;&nbsp;<?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Quantity</label>
               <div ><?php echo $material_detail->quantity;?></div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Purpose</label>								
               <div ><?php echo $material_detail->purpose;?></div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Preffered Supplier</label>
               <div>
                  <?php if(!empty($suppliername)){                                  
                     $indents->preffered_supplier;                                   
                     $supplierName=getNameById('supplier',$indents->preffered_supplier,'id');                     
                     ?>                      
                  <?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
                  <?php }?>								
               </div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
               <label>Expected Amount</label>								
               <div ><?php echo number_format($material_detail->sub_total);?></div>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 form-group col" style="border-right:1px solid #c1c1c1 ;">
               <label>Total Amount</label>								
               <div ><?php echo $material_detail->sub_total;?></div>
            </div>
         </div>
         <?php }                                     
            }?>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12" style="clear:both; margin-top:22px;">
         <div class="col-md-8 col-sm-5 col-xs-12" style="float:left;">
            <h6><b>Document</b></h6>
            <div class="x_content">
               <div class="row">
                  <div class="col-md-6">									
                     <?php
                        if(!empty($docss)){										
                        	foreach($docss as $proofs){	
                         $ext = pathinfo($proofs['file_name'], PATHINFO_EXTENSION);
                        if($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'png' || $ext == 'ico'){
                        	echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'" alt="image" height="100" width="100"/><i class="fa fa-download"></i></a></div></div>';			
                        }else if($ext == 'ods' || $ext ==  'doc' || $ext ==  'docx' ){
                        	echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/docX.png"  height="100" width="100"/><i class="fa fa-download"></i></a></div></div>';	
                        }else if($ext == 'pdf'){
                        	echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/PDF.png"  height="100" width="100"/><i class="fa fa-download"></i></a></div></div>';	
                        }else if($ext == 'xlsx'){
                        	echo '<div  class="col-md-4"><div class="image view view-first"><a download="'.$proofs['file_name'].'" href="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'"><img style="display: block;" src="'.base_url().'assets/images/excel.png"  height="100" width="100"/><i class="fa fa-download"></i></a></div></div>';	
                        }
                        }
                        }else{
                        echo 'There Are No Document';
                        	
                        } 
                        
                        ?>							
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
            <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 22px;color: #2C3A61; border-bottom: 1px solid #2C3A61;">
               <div class="col-md-5 col-sm-5 col-xs-6 text-right">
                  <input type="hidden" class="form-control has-feedback-left divSubTotal" name="total" id="total" value="0">
                  Total:
               </div>
               <div class="col-md-7 col-sm-5 col-xs-6 text-left">
                  <span class="divSubTotal fa fa-rupee" aria-hidden="true"><?php if(!empty($indents)){ echo number_format($indents->grand_total); } ?></span>
               </div>
            </div>
         </div>
      </div>
      <?php } ?>					
      <!--<table class="fixed data table table-bordered  no-margin" style="width:100%" id="print_divv" border="1" cellpadding="2" >            
         <thead>               
         	<tbody> 
         		<tr>				
         			<th>For Company Unit:</th>				
         			<td><b><?php if(!empty($indents)){ echo $indents->company_unit; } ?></b></td>       
         		</tr> 
         		<tr>                        
         			<th>Material Type:
         			</th>                     
         			<?php if(!empty($materialType)){ 
            $indents->material_type_id;                                    
            $material_type=getNameById('material_type',$indents->material_type_id,'id')->name;                     
            }                       
            ?>                      
         			<td>
         			<?php echo $material_type;?>
         			</td> </tr>
         			<tr>						
         			 <th>Inductor:
         			</th>                     
         			<td>
         			<?php if(!empty($indents)){ echo $indents->inductor; } ?>
         			</td> </tr>
         			<tr>
         			<th>Indent Number : </th>		
         			<td><?php echo $indents->indent_code; ?></td>
         		</tr>                   
         		<tr>                        
         			<th>Preferred Supplier</th> 
         			<?php if(!empty($suppliername)){                                  
            $indents->preffered_supplier;                                   
            $supplierName=getNameById('supplier',$indents->preffered_supplier,'id');                     
                                 
            ?>                      
         			<td>
         			<?php if(!empty($supplierName)){echo $supplierName->name; } else {echo "N/A";}?>
         			</td> 
         			<?php }?>
         		</tr>
         		<tr>
         		<th>Validate By</th>
         		  <td>
         		  <?php 
            // pre($indents);
              if(!empty($indents)){                                  
            	                                  
            	 $username = getNameById('user_detail',$indents->validated_by,'u_id');                     
            	echo $username->name;
              }
            	?>    
         		  </td>
         		</tr>
         		<tr>						
         			<th>Required Date:</th>                     
         			<td><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->required_date)); } ?></td>            						
         			           
         		</tr>
         		<tr>						
         			<th>Created Date:</th>                     
         			<td><?php if(!empty($indents)){ echo date("j F , Y", strtotime($indents->created_date)); } ?></td>            						
         			           
         		</tr>                   
         		
         		<tr>                        
         			<th>Department:
         			</th>                     
         			<td>
         			<?php if(!empty($indents)){ echo $indents->departments; } ?>
         			</td> </tr>
         			<tr>                            
         			 <th>Others:
         			</th>                     
         			<td>
         			<?php if(!empty($indents)){ echo $indents->other; } ?>
         			</td>
                              
         		</tr>                   
         		<tr>                        
         			<th>Specification:
         			</th>                     
         			<td>
         			<?php if(!empty($indents)){ echo $indents->specification; } ?>
         			</td>   </tr>
         			<tr>                                              
         			 <th>Material Description:</th>
         			 <th>
         			 <div class="table-responsive">
         			 <?php 
            if(($indents->material_name != '') && ($indents->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]')) {  ?>
         			 <table class="fixed data table table-bordered  no-margin" style="width:100%" border="1" cellpadding="2">
         				 <thead>
         				 <tbody>
         					 <tr>
         					 <th>Material Name</th>
         					 <th>Quantity</th>
         					 <th>Expected Amount</th>
         					 <th>Total Amount</th>
         					 <th>Purpose</th>
         					 
         					</tr>
         				
         					
         					<?php 
            if(!empty($indents) && $indents->material_name !='' && $indents->material_name != '[{"material_name_id":"","quantity":"","uom":"","expected_amount":"","purpose":"","sub_total":""}]'){					
            	$materialDetail =  json_decode($indents->material_name); 
            	$Total=0;									
            	foreach($materialDetail as $material_detail){
            	
            	$material_id=$material_detail->material_name_id;
            	$materialName=getNameById('material',$material_id,'id');
            	$Total+=$material_detail->sub_total;	
            	 
            	
            	?>		
         						<tr>
         						<td><h5><?php if (!empty($materialName)) {	echo $materialName->material_name;	} ?></h5><br><?php echo (array_key_exists("description",$material_detail)?$material_detail->description:''); ?></td>
         						<td><?php echo $material_detail->quantity;?><br /></td>
         						<td><?php echo number_format($material_detail->expected_amount);?><br /></td>
         						<td><?php echo number_format($material_detail->sub_total);?></td>
         						<td><?php echo $material_detail->purpose;?><br /></td>
         						
         						</tr>
         					<?php }                                     
            }?>
         					<tr>
         					<td colspan="3">Total</td>
         				<?php /* <td colspan="2"><?php echo number_format($Total);?></td> */?>
         					<td colspan="2"><?php if(!empty($indents)){ echo number_format($indents->grand_total); } ?></td>
         					</tr>
         				</tbody>
         				</thead>
         			</table> 
         			<?php } ?>
         			</th>
         			 
         		</tr>
         		<tr Class='hidde'>
         			<td rowspan="2" colspan="10">
         				<h6><b>Document</b></h6>												
         				<div class="x_content">							
         					<div class="row">									
         						<div class="col-md-6">									
         							<?php if(!empty($docss)){										
            foreach($docss as $proofs){								
            	echo '<div  class="col-md-55"><div class="image view view-first"><img style="display: block;" src="'.base_url().'assets/modules/purchase/uploads/'.$proofs['file_name'].'" alt="image" height="100" width="100"/></div></div>';				
            }
            }else{
            echo 'There Are No Document';
            
            } 
            
            ?>									
         						</div>							
         					</div>                          						
         				</div>	
         			</td>
         		</tr>
         			
         	</tbody>          
         </thead>      
         </table>-->
   </div>
   <div class="col-md-12 col-xs-12">
      <center>
         <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
      </center>
   </div>
</div>